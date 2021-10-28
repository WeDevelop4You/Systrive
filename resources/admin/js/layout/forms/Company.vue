<template>
    <v-row no-gutters>
        <v-col cols="12">
            <v-text-field
                v-model="value.name"
                :label="$vuetify.lang.t('$vuetify.word.name')"
                :error-messages="errors.name"
                dense
                outlined
            />
        </v-col>
        <v-col cols="12">
            <v-autocomplete
                v-model="value.owner"
                :items="owners"
                :search-input.sync="search"
                :loading="isLoading"
                :label="$vuetify.lang.t('$vuetify.word.owner')"
                :error-messages="errors.owner"
                :hide-details="isEditing && showCheckbox"
                item-text="email"
                open-on-clear
                return-object
                clearable
                no-filter
                dense
                outlined
            >
                <template #selection="{ item }">
                    <span>{{ item.full_name }} ({{ item.email }})</span>
                </template>
                <template #item="{ item }">
                    <v-list-item-content>
                        <v-list-item-title v-text="item.full_name" />
                        <v-list-item-subtitle v-text="item.email" />
                    </v-list-item-content>
                </template>
            </v-autocomplete>
        </v-col>
        <v-col
            v-if="isEditing"
            v-show="showCheckbox"
            cols="12"
        >
            <v-checkbox
                v-model="value.removeUser"
                :label="$vuetify.lang.t('$vuetify.text.remove.owner')"
                :error-messages="errors.owner"
                dense
                class="mb-2"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                :error-messages="errors.email"
                dense
                outlined
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.domain"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                :error-messages="errors.domain"
                dense
                outlined
            />
        </v-col>
        <v-col cols="12">
            <v-textarea
                v-model="value.information"
                :label="$vuetify.lang.t('$vuetify.word.information')"
                dense
                outlined
            />
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import _ from "lodash";

    export default {
        name: "Company",

        props: {
            value: {
                required: true,
                type: Object,
            },
        },

        data() {
            return {
                search: '',
                owner_id: null,
                isLoading: false,
            }
        },

        computed: {
            showCheckbox() {
                return this.owner_id !== this.value.owner?.id
            },

            ...mapGetters({
                errors: 'companies/errors',
                owners: "companies/owners",
                isEditing: "companies/isEditing",
            })
        },

        watch: {
            search: _.debounce(function () {
                if (this.isLoading || !this.search) return

                this.isLoading = true
                this.$store.dispatch('companies/userList', this.search).finally(() => {
                    this.isLoading = false
                })
            }, 500),
        },

        created() {
            if (this.isEditing) {
                this.owner_id = this.value.owner.id;
            }
        },
    }
</script>
