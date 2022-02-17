<template>
    <l-buttons>
        <v-btn
            v-for="(button, index) in data"
            :key="index"
            :color="button.color"
            :text="button.type === 'text'"
            small
            @click="runAction(button.action || null)"
            v-text="button.title"
        />
    </l-buttons>
</template>

<script>
    import LButtons from "./Buttons";

    export default {
        name: "ActionButtons",

        components: {
            LButtons,
        },

        props: {
            data: {
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

            returnIsPromise(func = null) {
                return !(!func || func.constructor.name === 'AsyncFunction' || (typeof func === 'function' && this.isPromise(func())));
            },

            isPromise(promise) {
                return typeof promise === 'object' && typeof promise.then === 'function';
            },

            close() {
                this.$store.commit('popups/closeModal')
            }
        }
    }
</script>
