<template>
    <component
        v-bind="component.attributes"
        :is="component.data.type"
        :value="component"
    />
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Table",

        components: {
            LocaleDataTableComponent: () => import('../Tables/LocaleDataTable.vue'),
            ServerDataTableComponent: () => import('../Tables/ServerDataTable.vue')
        },

        extends: ComponentBase,

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
                    items: this.component.data.itemsUrl,
                    headers: this.component.data.headerUrl,
                })

                this.$store.dispatch(`${this.vuexNamespace}/getHeaders`)
            }
        }
    }
</script>
