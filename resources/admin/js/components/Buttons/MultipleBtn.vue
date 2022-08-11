<template>
    <v-row
        :class="value.data.classes || []"
        no-gutters
        class="align-center justify-end"
    >
        <component
            :is="btn.componentName"
            v-for="btn in value.data.buttons"
            :key="btn.identifier"
            :value="btn"
        />
    </v-row>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "MultipleBtn",

        components: {
            Btn: () => import('./Btn.vue'),
            IconBtn: () => import('./IconBtn.vue'),
        },

        mixins: [
            ComponentProperties,
        ],

        data() {
            return {
                defaultBtn: {}
            }
        },

        created() {
            this.findDefaultBtn()
        },

        methods: {
            findDefaultBtn() {
                const buttons = this.value.data.buttons

                if (buttons) {
                    for (const btn of buttons) {
                        if (btn.data.isDefault && btn.data.action) {
                            this.defaultBtn = btn

                            break
                        }
                    }
                }
            },

            runDefaultAction() {
                const defaultBtn = this.defaultBtn

                if (defaultBtn) {
                    this.$actions.call(defaultBtn.data.action)
                }
            }
        }
    }
</script>
