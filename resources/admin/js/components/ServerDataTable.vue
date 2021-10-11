<template>
    <v-data-table
        :page="page"
        :items="items"
        :headers="headers"
        :loading="isLoading"
        :footer-props="{
            itemsPerPageOptions: itemsPerPageOptions
        }"
        :server-items-length="total"
        multi-sort
        calculate-widths
        @update:options="updateTable"
    >
        <template v-slot:top>
            <v-toolbar flat color="transparent">
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <slot name="toolbar.prepend"></slot>
                <v-divider class="mx-4" inset vertical/>
                <template v-if="searchable">
                    <v-text-field v-model="search" @input="updateSearch" hide-details :label="$vuetify.lang.t('$vuetify.word.search')" class="mx-auto" style="max-width: 700px"></v-text-field>
                </template>
                <slot name="toolbar.append"></slot>
            </v-toolbar>
        </template>
        <template v-slot:[`item.${customItem.name}`]="{item, isMobile, header, index}" v-for="customItem in customItems">
            <component :is="customItem.component" :item="item" :is-mobile="isMobile" :header="header" :index="index" :key="customItem.name"/>
        </template>
    </v-data-table>
</template>

<script>
    import _ from "lodash";

    export default {
        name: "ServerDataTable",

        props: {
            title: {
                required: true,
                type: String
            },

            route: {
                required: true,
                type: String
            },

            headers: {
                required: true,
                type: Array
            },

            vuexGetter: {
                required: true,
                type: String
            },

            vuexCommit: {
                required: true,
                type: String,
            },

            searchable: {
                type: Boolean,
                default: false
            },

            customItems: {
                type: Array,
                default: () => [],
            },

            itemsPerPageOptions: {
                type: Array,
                default: () => [
                    10,
                    25,
                    50
                ]
            }
        },

        data() {
            return {
                page: 1,
                total: 0,
                search: '',
                sorting: [],
                isLoading: true,
                itemsPerPage: 10
            }
        },

        computed: {
            items() {
                return this.$store.getters[this.vuexGetter]
            }
        },

        methods: {
            getData() {
                let app = this

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

                this.$api.call({
                    url: app.route,
                    method: 'GET',
                    params: params
                }).then((response) => {
                    const data = response.data

                    app.isLoading = false
                    app.total = data.meta.total

                    app.$store.commit(app.vuexCommit, data.data)
                })
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

                this.getData()
            },

            updateSearch: _.debounce(function () {
                this.page = 1
                this.getData()
            }, 500)
        }
    }
</script>
