<template>
    <card-base
        :title="title"
        no-padding
        no-action
    >
        <template #button>
            <slot name="edit" />
        </template>
        <v-list
            dense
            color="transparent"
            class="dialog-divide-color pt-0"
        >
            <template v-for="(item, key) in value">
                <template v-if="item.divider">
                    <v-divider
                        :key="key"
                        class="my-1"
                    />
                </template>
                <template v-else-if="item.subheader">
                    <v-subheader
                        :key="key"
                        class="subtitle-1"
                        style="height: 25px"
                        v-text="item.subheader"
                    />
                </template>
                <template v-else>
                    <v-list-item
                        v-for="(detail, index) in item.details"
                        :key="detail.identifier"
                        dense
                    >
                        <v-list-item-content>
                            <v-list-item-title v-text="detail.label" />
                            <template v-if="detail.type !== 'Text'">
                                <component
                                    :is="detail.type"
                                    v-model="detail.value"
                                />
                            </template>
                            <template v-else>
                                <slot
                                    :name="`detail.${detail.identifier}`"
                                    :index="index"
                                    :value="detail.value"
                                >
                                    <v-list-item-subtitle v-text="detail.value || $vuetify.lang.t('$vuetify.word.no_content')" />
                                </slot>
                            </template>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </template>
        </v-list>
    </card-base>
</template>

<script>
    import CardBase from "./CardBase";

    export default {
        name: "DetailsCard",

        components: {
            CardBase,
            URL: () => import(/* webpackChunkName: "component/items/url" */ '../items/URL'),
            Badges: () => import(/* webpackChunkName: "component/items/group_badges" */ '../items/GroupBadges'),
        },

        props: {
            value: {
                required: true,
                type: Array
            },

            title: {
                type: String,
                default: ''
            },
        },
    }
</script>
