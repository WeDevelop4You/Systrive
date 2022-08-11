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
            LocaleDataTable: () => import('../Tables/LocaleDataTable.vue'),
            ServerDataTable: () => import('../Tables/ServerDataTable.vue')
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
