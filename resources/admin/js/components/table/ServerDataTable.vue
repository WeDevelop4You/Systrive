<template>
    <div>
        <v-data-table
            :page="page"
            :items="items"
            :headers="headers"
            :footer-props="{
                itemsPerPageOptions: itemsPerPageOptions
            }"
            :server-items-length="total"
            multi-sort
            calculate-widths
            :class="'elevation-' + $config.elevation"
            class="rounded-lg v-sheet--outlined"
            @update:options="updateTable"
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
                            @input="updateSearch"
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
                    :item-index="index + 1 + ((page - 1) * itemsPerPage)"
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
    import _ from "lodash";
    import TableProperties from "../../mixins/DataTable/TableProperties";

    export default {
        name: "ServerDataTable",

        mixins: [
            TableProperties
        ],

        props: {
            headerRoute: {
                required: true,
                type: String
            },

            itemRoute: {
                required: true,
                type: String
            },
        },

        data() {
            return {
                page: 1,
                sorting: [],
                itemsPerPage: 10
            }
        },

        watch: {
            itemRoute: function(value) {
                this.$store.dispatch(`${this.vuexNamespace}/getItems`, value)
            }
        },

        created() {
            this.$store.commit(`${this.vuexNamespace}/setRoutes`, {
                items: this.itemRoute,
                headers: this.headerRoute,
            })

            this.$store.dispatch(`${this.vuexNamespace}/getHeaders`)
        },

        methods: {
            generateParams() {
                const params = {
                    page: this.page,
                    itemPerPage: this.itemsPerPage
                }

                if (this.search) {
                    params.search = this.search
                }

                if (this.sorting.length !== 0) {
                    params.sorting = this.sorting
                }

                this.$store.commit(`${this.vuexNamespace}/setParams`, params)

                this.load()
            },

            updateTable({page, itemsPerPage, sortBy, sortDesc}) {
                this.sorting = []
                this.isLoading = true

                this.page = page
                this.itemsPerPage = itemsPerPage

                for (let i = 0; i < sortBy.length; i++) {
                    const value = sortBy[i]
                    const direction = sortDesc[i] ? 'desc' : 'asc'

                    this.sorting[i] = `${value}_${direction}`
                }

                this.generateParams()
            },

            updateSearch: _.debounce(function () {
                this.page = 1
                this.generateParams()
            }, 500),
        }
    }
</script>
