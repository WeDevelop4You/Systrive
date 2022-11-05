<template>
    <v-list-item
        dense
        color="secondary"
        class="cursor-default text--primary"
        active-class="no-active"
    >
        <navigation-item-icon
            :value="icon"
            :is-hidden="isHidden"
        />
        <v-list-item-content style="padding-bottom: 10px">
            <v-list-item-title v-text="component.content.title" />
        </v-list-item-content>
        <v-list-item-action class="my-2">
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
    import NavigationItemIcon from "../NavigationItemIcon.vue";
    import Component from "../../../../../helpers/Components/Component";
    import ComponentBase from "../../../../Base/ComponentBase";

    export default {
        name: "DarkModeSwitchList",

        extends: ComponentBase,

        components: {
            NavigationItemIcon
        },

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
            }
        },
    }
</script>

<style scoped>

</style>
