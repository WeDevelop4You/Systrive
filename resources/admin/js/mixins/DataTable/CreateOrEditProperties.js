export default {
    computed: {
        showCreateOrEdit: {
            get() {
                return this.$store.getters[`${this.vuexNamespace}/isCreateOrEditModalOpen`]
            },

            set(value) {
                !value ? this.$store.commit(`${this.vuexNamespace}/resetCreateOrEdit`) : undefined
            }
        },

        data: {
            get() {
                return this.$store.getters[`${this.vuexNamespace}/data`]
            },

            set(values) {
                this.$store.commit(`${this.vuexNamespace}/setData`, values)
            }
        },

        errors() {
            return this.$store.getters[`${this.vuexNamespace}/errors`]
        },

        isEditing() {
            return this.$store.getters[`${this.vuexNamespace}/isEditing`]
        },

        createOrEditTitle() {
            return this.isEditing
                ? this.$vuetify.lang.t('$vuetify.word.edit.edit')
                : this.$vuetify.lang.t('$vuetify.word.create.create');
        },
    },

    mounted() {
        this.$refs.createOrEdit.$on('save', this.save)
    },

    methods: {
        openCreate() {
            this.$store.commit(`${this.vuexNamespace}/setCreate`)
        },

        async save() {
            if (this.isEditing) {
                await this.$store.dispatch(`${this.vuexNamespace}/update`, this.data)
            } else {
                await this.$store.dispatch(`${this.vuexNamespace}/create`, this.data)
            }

            await this.$store.dispatch(`${this.vuexNamespace}/getMany`)
        },


    }
}
