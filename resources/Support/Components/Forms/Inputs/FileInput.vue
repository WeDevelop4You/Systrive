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
                >{{ component.attributes.placeholder }}</span>
            </template>
        </v-file-input>
        <files
            :max="max"
            :files="files"
            :is-disabled="isDisabled"
            @remove="remove"
        />
    </div>
</template>

<script>
    import FileInputComponentBase from "../../Base/Inputs/FileInputComponentBase";

    export default {
        name: "FileInput",

        extends: FileInputComponentBase,

        methods: {
            handler(files) {
                if (files instanceof Array) {
                    files.forEach((file) => {
                        if (this.files.length < this.max) {
                            this.create(file)
                        }
                    })
                } else {
                    this.create(files)
                }
            },

            create(file) {
                const data = this.createFormData(file)
                const index = this.createProgress(file.size)

                this.uploader(data, index)
            }
        }
    }
</script>

