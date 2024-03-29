<template>
    <div>
        <template v-if="!headers.length">
            <skeleton-data-table />
        </template>
        <v-data-table
            v-show="headers.length"
            :items="items"
            :headers="headers"
            :page.sync="page"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :items-per-page.sync="itemsPerPage"
            :server-items-length="total"
            :class="{[`rounded-lg v-sheet--outlined ${elevation}`]: !component.data.isFlat}"
            :footer-props="{
                itemsPerPageOptions: component.data.totalPerPageOptions
            }"
            multi-sort
            calculate-widths
            @update:options="updateOptions"
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
                    <template v-if="component.data.searchable">
                        <v-text-field
                            v-model="search"
                            class="mr-auto"
                            :label="$vuetify.lang.t('$vuetify.word.search')"
                            dense
                            outlined
                            hide-details
                            style="max-width: 500px"
                            @input="updateSearch"
                        />
                    </template>
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
    import {debounce as _debounce} from "lodash";
    import TableComponentBase from "../../Base/TableComponentBase";

    export default {
        name: "ServerDataTable",

        extends: TableComponentBase,

        data() {
            return {
                page: 1,
                sortDesc: [],
                itemsPerPage: this.value.data.totalPerPage
            }
        },

        methods: {
            resetParams() {
                this.page = 1
                this.search = ''
                this.sortBy = []
                this.sortDesc = []
                this.itemsPerPage = this.value.data.totalPerPage

                this.generateParams()
            },

            generateParams() {
                const sortByLength = this.sortBy.length
                const params = {
                    page: this.page,
                    itemsPerPage: this.itemsPerPage
                }

                if (this.search) {
                    params.search = this.search

                }

                if (sortByLength) {
                    params.sorting = []

                    for (let i = 0; i < sortByLength; i++) {
                        const value = this.sortBy[i]
                        const direction = this.sortDesc[i] ? 'desc' : 'asc'

                        params.sorting.push(`${value}_${direction}`)
                    }
                }

                this.$store.commit(`${this.vuexNamespace}/setParams`, params)

                this.load()
            },

            updateOptions({page, itemsPerPage, sortBy, sortDesc}) {
                this.page = page;
                this.sortBy = sortBy
                this.sortDesc = sortDesc
                this.itemsPerPage = itemsPerPage

                this.generateParams()
            },

            updateSearch: _debounce(function () {
                this.page = 1

                this.generateParams()
            }, 500),
        }
    }
</script>
