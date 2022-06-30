<template>
    <component
        v-bind="value.attributes"
        :is="value.data.type"
        :value="value"
    />
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Table",

        components: {
            LocaleDataTable: () => import(/* webpackChunkName: "components/tables/locale_data_table" */ '../Tables/LocaleDataTable'),
            ServerDataTable: () => import(/* webpackChunkName: "components/tables/server_data_table" */ '../Tables/ServerDataTable')
        },

        mixins: [
            ComponentProperties
        ],

        data() {
            return {
                vuexNamespace: this.value.attributes.vuexNamespace,
            }
        },

        created() {
            this.setup()
        },

        methods: {
            setup() {
                this.$store.commit(`${this.vuexNamespace}/setRoutes`, {
                    items: this.value.data.itemsUrl,
                    headers: this.value.data.headerUrl,
                })

                this.$store.dispatch(`${this.vuexNamespace}/getHeaders`)
            }
        }
    }
</script>
