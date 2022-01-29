<template>
    <v-list-item-group
        color="primary"
    >
        <v-list-item
            v-for="(navigation, index) in item.navigationItems"
            :key="index"
            :class="{'pl-2': isMini}"
            :to="navigation.route"
            dense
        >
            <template v-if="$auth.can(navigation.can)">
                <template v-if="navigation.avatar">
                    <v-list-item-avatar
                        :class="{'mr-2': !isMini}"
                        class="my-1"
                        max-width="28"
                        max-height="28"
                    >
                        <v-img
                            max-width="28"
                            max-height="28"
                            :src="navigation.avatar"
                        />
                    </v-list-item-avatar>
                </template>
                <template v-else>
                    <v-list-item-icon
                        :class="{'mr-2': !isMini}"
                        class="justify-center"
                        style="min-width: 40px"
                    >
                        <v-icon
                            v-text="navigation.icon"
                        />
                    </v-list-item-icon>
                </template>
                <v-list-item-content>
                    <v-list-item-title v-html="navigation.name" />
                </v-list-item-content>
            </template>
        </v-list-item>
    </v-list-item-group>
</template>

<script>
    export default {
        name: "NavigationItem",

        props: {
            item: {
                required: true,
                type: Object,
            },

            isMini: {
                required: true,
                type: Boolean,
            }
        }
    }
</script>
