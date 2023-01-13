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
            @change="addFiles"
        >
            <template #selection="{ index }">
                <span
                    v-if="index === 0"
                    class="text--secondary"
                >{{ component.attributes.placeholder }}</span>
            </template>
        </v-file-input>
        <v-row
            class="my-1"
            dense
        >
            <v-col
                v-for="(file, index) in files"
                :key="index"
                :cols="12"
            >
                <v-card
                    outlined
                    class="file"
                >
                    <div
                        v-if="file.identifier"
                        class="d-flex flex-no-wrap"
                    >
                        <v-icon
                            class="my-3 ml-3"
                            size="40"
                            v-text="icon(file.type)"
                        />
                        <div>
                            <v-card-title
                                class="text-body-1"
                                v-text="file.name"
                            />
                            <v-card-subtitle
                                class="text-caption"
                                v-text="format(file.size)"
                            />
                        </div>
                        <v-spacer />
                        <v-card-actions>
                            <v-btn
                                icon
                                class="my-3 mr-3"
                                @click="remove(file, index)"
                            >
                                <v-icon>fas fa-trash</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </div>
                    <v-card-text v-else>
                        <v-progress-linear
                            :value="file.progress"
                            stream
                            color="primary"
                            buffer-value="0"
                            class="ma-5 w-auto"
                        />
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12">
                <div
                    class="v-counter ml-2 float-end"
                    v-text="counter"
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import numeral from "numeral"
    import FormComponentBase from "../../Base/FormComponentBase";
    import NotificationComponent from "../../../Helpers/Components/NotificationComponent";

    export default {
        name: "FileInput",

        extends: FormComponentBase,

        data() {
            return {
                files: [],
                deletedFiles: [],
                max: this.value.data.max ?? 1
            }
        },

        computed: {
            counter() {
                const amount = `${this.files.length}/${this.max}`

                return this.$vuetify.lang.t('$vuetify.fileInput.counterSize', amount, this.total)
            },

            total() {
                if (this.files.length < 1) {
                    return this.format(0)
                }

                return this.format(this.files.map(item => item.size).reduce((prev, next) => prev + next))
            }
        },

        methods: {
            addFiles(files) {
                if (files instanceof Array) {
                    files.forEach((file) => {
                        if (this.files.length < this.max) {
                            this.uploader(file)
                        }
                    })
                } else {
                    this.uploader(files)
                }
            },

            uploader(file) {
                const index = this.createProgress(file.size)

                this.$api.call({
                    url: this.component.data.uploaderRoute,
                    method: 'POST',
                    data: this.createFormData(file),
                    headers: {
                        'content-type': 'multipart/form-data'
                    },
                    onUploadProgress: (progressEvent) => {
                        this.files.at(index).progress = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    }
                }).then((response) => {
                    this.$set(this.files, index, response.data.data)

                    this.setValue(this.files)
                }).catch((error) => {
                    this.files.splice(index, 1)

                    this.$store.dispatch(
                        'popups/addPopup',
                        NotificationComponent.createSimple(error.response.data.errors[this.key][0])
                    )
                })
            },

            createProgress(size) {
                const total = this.files.push({
                    size: size,
                    progress: 0
                })

                return total - 1
            },

            createFormData(file) {
                const form = new FormData()
                form.append('file', file)

                return form
            },

            remove(file, index) {
                if (this.isset(file, 'id')) {
                    this.deletedFiles.push(file.id)

                    this.data['deleted_files'] = {
                        [this.key]: this.deletedFiles
                    }
                }

                this.files.splice(index, 1)

                this.setValue(this.files)
            },

            format(size) {
                return numeral(size).format('0.[00] b')
            },

            icon(type) {
                switch (type) {
                    case 'application/vnd.ms-excel':
                    case 'application/vnd.oasis.opendocument.spreadsheet':
                    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                        return 'fas fa-file-excel'

                    case 'application/msword':
                    case 'application/vnd.oasis.opendocument.text':
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                        return 'fas fa-file-word'

                    case 'application/vnd.ms-powerpoint':
                    case 'application/vnd.oasis.opendocument.presentation':
                    case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                        return 'fas fa-file-powerpoint'

                    case 'application/pdf':
                        return 'fas fa-file-pdf'

                    case 'video/mp4':
                        return 'fas fa-file-video'

                    case 'audio/mp3':
                        return 'fas fa-file-audio'

                    case 'application/zip':
                    case 'application/gzip':
                    case 'application/vnd.rar':
                    case 'application/x-7z-compressed':
                        return 'fas fa-file-archive'

                    case 'application/x-httpd-php':
                        return 'fas fa-file-code'

                    case 'text/plain':
                        return 'fas fa-file-alt'

                    default:
                        return 'fas fa-file'
                }
            }
        }
    }
</script>

