<template>
    <div>
        <v-file-input
            v-bind="component.attributes"
            :clearable="false"
            :disabled="isDisabled || files.length >= max"
            :label="component.content.label"
            :error-messages="errorMessages"
            :error="component.data.error && error"
            :hide-details="hideDetails"
            :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
            @change="handler"
        >
            <template #selection="{ index }">
                <span
                    v-if="index === 0"
                    class="text--secondary"
                >
                    {{ component.attributes.placeholder }}
                </span>
            </template>
        </v-file-input>
        <files
            :max="max"
            :files="files"
            :is-disabled="isDisabled"
            @remove="remove"
        />
        <Dialog :value="dialog" />
    </div>
</template>

<script>
    import Dialog from "../../Popups/Dialog.vue";
    import Cropper from "../../../Store/Modules/cropper";
    import FileInputComponentBase from "../../Base/Inputs/FileInputComponentBase";

    export default {
        name: "ImageInput",

        components: {
            Dialog,
        },

        extends: FileInputComponentBase,

        data() {
            return {
                dialog: this.value.data.dialog,
                vuexCropperNamespace: this.value.data.vuexCropperNamespace
            }
        },

        created() {
            if (!this.$store.hasModule(this.getPath())) {
                this.$store.registerModule(this.getPath(), Cropper({
                    modalCallback: (value) => this.dialog.data.show = value,
                    uploaderCallback: (file, {width, height, left, top}) => {
                        const data = this.createFormData(file)
                        const index = this.createProgress(file.size)

                        data.append('width', width)
                        data.append('height', height)
                        data.append('left', left)
                        data.append('top', top)

                        return this.uploader(data, index)
                    }
                }))
            }
        },

        beforeDestroy() {
            this.$store.unregisterModule(this.getPath())
        },

        methods: {
            getPath() {
                return this.vuexCropperNamespace.split('/')
            },

            handler(files) {
                const type = `${this.vuexCropperNamespace}/add`

                if (files instanceof Array) {
                    files.forEach((file) => {
                        if (this.files.length < this.max) {
                            this.$store.commit(type, file)
                        }
                    })
                } else {
                    this.$store.commit(type, files)
                }
            },
        }
    }
</script>

