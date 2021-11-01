<template>
    <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
    >
        <v-card>
            <v-toolbar dense>
                <v-toolbar-title
                    class="ml-5"
                    v-text="title"
                />
                <v-spacer />
                <v-btn
                    class="mr-5"
                    icon
                    @click="resetDialog"
                >
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-progress-linear
                    absolute
                    bottom
                    indeterminate
                    :active="$loading"
                    color="primary"
                />
            </v-toolbar>
            <v-card-text class="my-5">
                <slot />
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "ShowDialog",

        props: {
            title: {
                required: true,
                type: String
            },

            vuexNamespace: {
                required: true,
                type: String
            },
        },

        computed: {
            dialog() {
                const dialog = this.$store.getters[`${this.vuexNamespace}/isShowDialogOpen`]

                dialog ? this.$emit('open') : this.$emit('close')

                return dialog
            }
        },

        methods: {
            async resetDialog() {
                await this.$router.replace({name: this.$route.name})

                this.$store.commit(`${this.vuexNamespace}/resetShow`)
            }
        }
    }
</script>
