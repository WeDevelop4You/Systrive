<template>
    <v-list
        dense
        color="transparent"
        class="dialog-divide-color pt-0"
    >
        <template v-for="(property, index) in component.data.list">
            <template v-if="property.divider">
                <v-divider
                    :key="index"
                    class="my-1"
                />
            </template>
            <template v-else-if="property.subheader">
                <v-subheader
                    :key="index"
                    :class="[component.data.hasSubheader ? 'pl-4' : '']"
                    class="subtitle-1"
                    style="height: 25px"
                    v-text="property.subheader"
                />
            </template>
            <template v-else>
                <v-row
                    :key="index"
                    no-gutters
                >
                    <v-col
                        v-for="item in property.items"
                        :key="item.identifier"
                        :md="property.columns"
                        cols="12"
                    >
                        <v-list-item
                            :class="[component.data.hasSubheader ? 'pl-6' : '']"
                            dense
                        >
                            <v-list-item-content>
                                <v-list-item-title v-text="item.content.label" />
                                <template v-if="item.componentName !== 'Content'">
                                    <component
                                        :is="item.componentName"
                                        :value="item"
                                        :class="{'mt-1 max-w-min-content': item.componentName === 'Badge'}"
                                    />
                                </template>
                                <template v-else>
                                    <v-list-item-subtitle v-text="item.content.value || $vuetify.lang.t('$vuetify.word.no_content')" />
                                </template>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                </v-row>
            </template>
        </template>
    </v-list>
</template>

<script>
    import MainComponentBase from "../Base/MainComponentBase";

    export default {
        name: "List",

        extends: MainComponentBase,
    }
</script>
