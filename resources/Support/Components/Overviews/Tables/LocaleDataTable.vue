<template>
    <div>
        <template v-if="!headers.length">
            <skeleton-data-table />
        </template>
        <v-data-table
            v-show="headers.length"
            :items="items"
            :search="search"
            :headers="headers"
            :sort-by.sync="sortBy"
            :items-per-page="component.data.totalPerPage"
            :disable-pagination="component.data.disablePagination"
            :hide-default-footer="component.data.disablePagination"
            :class="{[`rounded-lg v-sheet--outlined ${elevation}`]: !component.data.isFlat}"
            :footer-props="{
                itemsPerPageOptions: component.data.totalPerPageOptions
            }"
            multi-sort
            calculate-widths
        >
            <template #top>
                <v-row
                    v-if="component.content.title"
                    no-gutters
                    class="px-4 pt-3"
                >
                    <span class="headline">{{ component.content.title }}</span>
                </v-row>
                <v-toolbar
                    flat
                    color="transparent"
                    class="px-4"
                >
                    <component
                        :is="component.data.prepend.componentName"
                        v-if="component.data.prepend"
                        :value="component.data.prepend"
                    />
                    <v-spacer />
                    <component
                        :is="component.data.append.componentName"
                        v-if="component.data.append"
                        :value="component.data.append"
                    />
                    <v-text-field
                        v-if="component.data.searchable"
                        v-model="search"
                        class="mr-auto"
                        :label="$vuetify.lang.t('$vuetify.word.search')"
                        dense
                        outlined
                        hide-details
                        style="max-width: 500px"
                    />
                </v-toolbar>
            </template>
            <template
                v-for="customItem in customItems"
                #[`item.${customItem}`]="{item, index}"
            >
                <component
                    :is="item[customItem].componentName"
                    v-if="item[customItem].hasOwnProperty('componentName')"
                    :key="item[customItem].identifier"
                    :value="item[customItem]"
                />
                <div
                    v-else
                    :key="`${customItem}_${index}`"
                >
                    {{ item[customItem] }}
                </div>
            </template>
            <template
                v-if="component.data.refreshButton"
                #footer.prepend
            >
                <v-btn icon>
                    <v-icon
                        @click="getItems"
                    >
                        fas fa-sync-alt
                    </v-icon>
                </v-btn>
            </template>
        </v-data-table>
        <slot />
    </div>
</template>

<script>

import TableComponentBase from "../../Base/TableComponentBase";

export default {
    name: "LocaleDataTable",

    extends: TableComponentBase,

    created() {
        this.load()
    },

    methods: {
        resetParams() {
            this.search = ''
            this.sortBy = []
        }
    }
}
</script>
