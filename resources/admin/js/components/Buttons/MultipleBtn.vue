<template>
    <v-row
        :class="component.data.classes || []"
        no-gutters
        class="align-center justify-end"
    >
        <component
            :is="btn.componentName"
            v-for="btn in component.data.buttons"
            :key="btn.identifier"
            :value="btn"
        />
    </v-row>
</template>

<script>
    import MainComponentBase from "../Base/MainComponentBase";

    export default {
        name: "MultipleBtn",

        extends: MainComponentBase,

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
                const buttons = this.component.data.buttons

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
