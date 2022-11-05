<script>
    import SelectInput from "../SelectInput.vue";

    export default {
        name: "SelectColumnInput",

        extends: SelectInput,

        created() {
            let hasDefault = false
            const defaultText = this.$vuetify.lang.t('$vuetify.word.default')

            const items = this.$store.getters['company/cms/table/columns/getItems'].map((item, index) => {
                if (item.original_key === this.data.original_key) {
                    hasDefault = true

                    return  {text: defaultText, value: 'default'}
                }

                return {text: item.label, value: index + (hasDefault ? 0 : 1)}
            })

            if (!hasDefault) {
                items.unshift( {text: defaultText, value: 'default'})
            }

            this.component.data.items = items
        }
    }
</script>
