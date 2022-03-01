<template>
    <l-buttons>
        <v-btn
            v-for="(button, index) in value"
            :key="index"
            :color="button.color"
            :text="button.type === 'text'"
            :block="button.type === 'block'"
            :outlined="button.type === 'outlined'"
            :small="button.size === 's'"
            :x-small="button.size === 'xs'"
            :elevation="button.color === 'transparent' ? 0 : 1"
            @click="runAction(button.action || null)"
            v-text="button.title"
        />
    </l-buttons>
</template>

<script>
    import LButtons from "../layout/Buttons";
    import PromiseChecker from "../mixins/PromiseChecker";

    export default {
        name: "ActionButtons",

        components: {
            LButtons,
        },

        mixins: [
            PromiseChecker
        ],

        props: {
            value: {
                required: true,
                type: Array
            }
        },

        data() {
            return {
                action: null
            }
        },

        created() {
            for (const button of this.data) {
                if (button.hasListener && button.action) {
                    this.action = button.action

                    break
                }
            }
        },

        methods: {
            runAction(action) {
                if (action) {
                    const promise = this.callAction(action)

                    if (this.returnIsPromise(promise)) {
                        promise.then(() => {
                            this.close()
                        }).catch(() => {})
                    } else {
                        this.close()
                    }
                } else {
                    this.close()
                }
            },

            runEventAction() {
                if (this.action) {
                    this.runAction(this.action)
                }
            },

            close() {
                this.$store.commit('popups/closeModal')
            }
        }
    }
</script>
