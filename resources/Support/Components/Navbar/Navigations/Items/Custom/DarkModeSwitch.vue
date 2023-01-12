<template>
    <v-list-item
        dense
        color="secondary"
        class="cursor-default text--primary"
        inactive
    >
        <v-list-item-icon
            style="min-width: 40px"
            class="justify-center mx-auto"
        >
            <icon
                :value="icon"
                :style="{color: iconColor}"
            />
        </v-list-item-icon>
        <v-list-item-content style="padding-bottom: 4px">
            <v-list-item-title v-text="component.content.title" />
        </v-list-item-content>
        <v-list-item-action class="mb-1 mt-2">
            <v-switch
                v-model="data"
                class="mt-0 pt-0"
                hide-details
                dense
            />
        </v-list-item-action>
    </v-list-item>
</template>

<script>
    import Icon from "../../../../Misc/Icons/Icon.vue";
    import ComponentBase from "../../../../Base/ComponentBase";
    import Component from "../../../../../helpers/Components/Component";

    export default {
        name: "DarkModeSwitchList",

        components: {
            Icon,
        },

        extends: ComponentBase,

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },

        computed: {
            data: {
                get() {
                    return this.$auth.preference('dark_mode')
                },

                set(value) {
                    this.$auth.changePreference('dark_mode', value)
                }
            },

            icon() {
                return new Component({
                    content: {
                        type: this.$vuetify.theme.dark ? 'fas fa-moon' : 'fas fa-sun'
                    },
                })
            },

            iconColor() {
                return this.$vuetify.theme.dark ? '#FFFFFF' : 'rgba(0, 0, 0, 0.54)'
            }
        },
    }
</script>

<style scoped>

</style>
