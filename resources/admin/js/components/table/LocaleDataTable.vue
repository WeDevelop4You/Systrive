<template>
    <div>
        <v-data-table
            :items="items"
            :search="search"
            :headers="headers"
            :footer-props="{
                itemsPerPageOptions: itemsPerPageOptions
            }"
            multi-sort
            calculate-widths
            :class="'elevation-' + $config.elevation"
            class="rounded-lg v-sheet--outlined"
        >
            <template #top>
                <v-row
                    no-gutters
                    class="px-4 pt-3"
                >
                    <span class="headline">{{ title }}</span>
                </v-row>
                <v-toolbar
                    flat
                    color="transparent"
                    class="px-4"
                >
                    <slot name="toolbar.prepend" />
                    <v-spacer />
                    <slot name="toolbar.center" />
                    <v-spacer />
                    <template v-if="searchable">
                        <v-text-field
                            v-model="search"
                            class="mr-auto"
                            :label="$vuetify.lang.t('$vuetify.word.search')"
                            dense
                            outlined
                            hide-details
                            style="max-width: 500px"
                        />
                    </template>
                    <slot name="toolbar.append" />
                </v-toolbar>
            </template>
            <template
                v-for="customItem in customItems"
                #[`item.${customItem.name}`]="{item, isMobile, header, index}"
            >
                <component
                    :is="customItem.component"
                    :key="customItem.name"
                    :item="item"
                    :is-mobile="isMobile"
                    :header="header"
                    :index="index"
                    :item-index="index + 1"
                    :vuex-namespace="vuexNamespace"
                    @refresh="load"
                />
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
import TableProperties from "../../mixins/DataTable/TableProperties";

export default {
    name: "LocaleDataTable",

    mixins: [
        TableProperties
    ],
}
</script>
