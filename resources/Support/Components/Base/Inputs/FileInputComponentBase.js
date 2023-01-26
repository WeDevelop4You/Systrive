import Files from "../../Misc/Files.vue";
import FormComponentBase from "../FormComponentBase";
import NotificationComponent from "../../../Helpers/Components/NotificationComponent";

export default {
    components: {
        Files
    },

    extends: FormComponentBase,

    data() {
        return {
            files: [],
            deletedFiles: [],
            max: this.value.data.max ?? 1
        }
    },

    mounted() {
        this.files = this.getValue()
    },

    methods: {
        uploader(data, index) {
            return this.$api.call({
                url: this.component.data.uploaderRoute,
                method: 'POST',
                data: data,
                headers: {
                    'content-type': 'multipart/form-data'
                },
                onUploadProgress: (progressEvent) => {
                    this.files.at(index).progress = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                }
            }).then((response) => {
                this.add(response.data.data, index)

                return Promise.resolve()
            }).catch((error) => {
                this.remove({}, index)
                this.$store.dispatch(
                    'popups/addPopup',
                    NotificationComponent.createSimple(error.response.data.errors[this.key][0])
                )

                return Promise.reject()
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

        add(data, index) {
            this.$set(this.files, index, data)

            this.setValue(this.files)
        },

        remove(file, index) {
            if (this.isset(file, 'id')) {
                this.deletedFiles.push(file.id)

                this.data['delete_files'] = {
                    [this.key]: this.deletedFiles
                }
            }

            this.files.splice(index, 1)

            this.setValue(this.files)
        },
    }
}