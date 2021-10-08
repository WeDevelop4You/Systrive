<template>
    <div>
        <v-data-table
            :items="items"
            :headers="headers"
            :loading="isLoading"
            :footer-props="{
                itemsPerPageOptions: [10,25,50]
            }"
            :server-items-length="total"
            multi-sort
            calculate-widths
            @update:options="updateTable"
        >
            <template v-slot:top>
                <v-toolbar flat color="transparent">
                    <v-toolbar-title>Users</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical/>
                    <v-text-field v-model="search" @input="updateSearch" hide-details :label="$vuetify.lang.t('$vuetify.word.search')" class="mx-auto" style="max-width: 700px"></v-text-field>
<!--                    <v-dialog v-model="dialog" max-width="700px" persistent>-->
<!--                        <template v-slot:activator="{ on }">-->
<!--                            <v-btn color="primary" class="mb-2 ml-4" v-on="on">{{ $vuetify.lang.t('$vuetify.word.new.account') }}</v-btn>-->
<!--                        </template>-->
<!--                        <v-card>-->
<!--                            <v-card-title>-->
<!--                                <span class="headline">{{ formTitle }}</span>-->
<!--                                <v-spacer/>-->
<!--                                <v-btn icon @click="close">-->
<!--                                    <v-icon>fas fa-times</v-icon>-->
<!--                                </v-btn>-->
<!--                            </v-card-title>-->
<!--                            <v-card-text>-->
<!--                                <f-account v-model="editedItems" :permissions="permissions" :edit="editedIndex !== -1" :errorMessage="errorMessage"/>-->
<!--                            </v-card-text>-->
<!--                            <v-card-actions class="px-6">-->
<!--                                <v-spacer></v-spacer>-->
<!--                                <v-btn text @click="close" :disabled="$root.loading">{{ $vuetify.lang.t('$vuetify.word.cancel') }}</v-btn>-->
<!--                                <v-btn color="primary" @click="save" :disabled="$root.loading">{{ $vuetify.lang.t('$vuetify.word.save') }}</v-btn>-->
<!--                            </v-card-actions>-->
<!--                        </v-card>-->
<!--                    </v-dialog>-->
                </v-toolbar>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import _ from "lodash";

    export default {
        name: "Users",

        data() {
            return {
                headers: [
                    {text: 'ID', value: 'id', sortable: true, align: 'start'},
                    {text: 'E-mail', value: 'email', sortable: true},
                    {text: 'E-mail verified at', value: 'email_verified_at', sortable: true},
                    {text: 'Created at', value: 'created_at', sortable: true},
                    {text: 'actions', value: 'actions', sortable: false},
                ],

                items: [],

                page: 1,
                total: 0,
                search: '',
                sorting: [],
                isLoading: true,
                itemsPerPage: 10
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
                    url: this.$api.route('admin.users'),
                    method: 'GET',
                    params: params
                }).then((response) => {
                    const data = response.data

                    app.isLoading = false

                    app.items = data.data
                    app.total = data.meta.total
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
                this.getData()
            }, 500)
        }
    }
</script>
