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
            :footer-props="{
                itemsPerPageOptions: itemsPerPageOptions
            }"
            multi-sort
            calculate-widths
            :class="{[`rounded-lg v-sheet--outlined ${elevation}`]: !value.data.isFlat}"
        >
            <template #top>
                <v-row
                    v-if="value.content.title"
                    no-gutters
                    class="px-4 pt-3"
                >
                    <span class="headline">{{ value.content.title }}</span>
                </v-row>
                <v-toolbar
                    flat
                    color="transparent"
                    class="px-4"
                >
                    <component
                        :is="value.data.prepend.componentName"
                        v-if="value.data.prepend"
                        :value="value.data.prepend"
                    />
                    <v-spacer />
                    <component
                        :is="value.data.append.componentName"
                        v-if="value.data.append"
                        :value="value.data.append"
                    />
                    <v-text-field
                        v-if="searchable"
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
                v-if="refreshButton"
                #footer.prepend
            >
                <v-btn icon>
                    <v-icon
                        @click="load"
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
import TableProperties from "../../mixins/TableProperties";

export default {
    name: "LocaleDataTable",

    mixins: [
        TableProperties
    ],

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
