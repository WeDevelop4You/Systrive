<template>
    <v-row
        class="my-1"
        dense
    >
        <v-col
            v-for="(file, index) in files"
            :key="index"
            :cols="12"
        >
            <v-row
                no-gutters
                align="center"
            >
                <v-col
                    cols="auto"
                    class="text-center"
                    style="width: 24px; margin-right: 9px"
                >
                    {{ index + 1 }}
                </v-col>
                <v-col>
                    <v-card
                        outlined
                        class="file"
                    >
                        <div
                            v-if="file.identifier || file.id"
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
                                    :disabled="isDisabled"
                                    icon
                                    class="my-3 mr-3"
                                    @click="$emit('remove', file, index)"
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
            </v-row>
        </v-col>
        <v-col cols="12">
            <div
                class="v-counter ml-2 float-end"
                v-text="counter"
            />
        </v-col>
    </v-row>
</template>

<script>
    import numeral from "numeral";

    export default {
        name: "Files",

        props: {
            max : {
                required: true,
                type: Number,
            },

            files: {
                required: true,
                type: Array
            },

            isDisabled: {
                required: true,
                type: Boolean,
                default: false
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