<template>
    <v-row>
        <v-col cols="4">
            <v-card
                class="mx-12"
                :elevation="$config.elevation"
                rounded="lg"
            >
                <v-card-title v-text="$vuetify.lang.t('$vuetify.word.account.settings')" />
                <v-card-text>
                    <v-list
                        nav
                        dense
                    >
                        <template v-for="(item, index) in navigationItems">
                            <template v-if="item.subheader">
                                <v-subheader :key="index">
                                    {{ item.subheader }}
                                </v-subheader>
                            </template>
                            <template v-else-if="item.divider">
                                <v-divider
                                    :key="index"
                                    class="my-1"
                                />
                            </template>
                            <template v-else>
                                <v-list-item-group
                                    :key="index"
                                    color="primary"
                                >
                                    <v-list-item
                                        v-for="(navigation, i) in item.navigationItems"
                                        :key="i"
                                        :to="navigation.route"
                                    >
                                        <v-list-item-icon>
                                            <v-icon v-text="navigation.icon" />
                                        </v-list-item-icon>

                                        <v-list-item-content>
                                            <v-list-item-title v-text="navigation.name" />
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </template>
                        </template>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="8">
            <router-view />
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "Account",

        computed: {
            navigationItems() {
                return [
                    {
                        navigationItems: [
                            {icon: 'fas fa-user', name: this.$vuetify.lang.t('$vuetify.word.personal.data'), route: {name: 'user.setting.personal'}},
                            {icon: 'fas fa-shield-alt', name: this.$vuetify.lang.t('$vuetify.word.security'), route: {name: 'user.setting.security'}},
                        ]
                    },
                ]
            }
        }
    }
</script>
