<template>
    <v-row no-gutters>
        <v-col
            v-if="$auth.can($config.permissions.superAdmin)"
            cols="12"
        >
            <v-text-field
                v-model="value.name"
                :label="$vuetify.lang.t('$vuetify.word.name')"
                :error-messages="errors.name"
                dense
                outlined
            />
        </v-col>
        <v-col
            v-if="$auth.can($config.permissions.superAdmin)"
            cols="12"
        >
            <v-combobox
                v-model="value.owner_email"
                :items="users"
                :label="$vuetify.lang.t('$vuetify.word.owner')"
                :error-messages="errors.owner_email"
                :hide-details="isEditing && showCheckbox"
                :return-object="false"
                item-value="email"
                item-text="email"
                clearable
                dense
                outlined
            >
                <template #selection="{ item }">
                    <span v-text="selectedText(item)" />
                </template>
                <template #item="{ item }">
                    <v-list-item-content>
                        <v-list-item-title v-text="item.email" />
                        <v-list-item-subtitle v-text="item.full_name" />
                    </v-list-item-content>
                </template>
            </v-combobox>
        </v-col>
        <v-col
            v-if="isEditing && $auth.can($config.permissions.superAdmin)"
            v-show="showCheckbox"
            cols="12"
        >
            <v-checkbox
                v-model="value.removeUser"
                :label="$vuetify.lang.t('$vuetify.text.remove.owner')"
                :error-messages="errors.owner_email"
                dense
                class="mb-2"
            />
        </v-col>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <v-text-field
                v-model="value.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                :error-messages="errors.email"
                dense
                outlined
            />
        </v-col>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <v-text-field
                v-model="value.domain"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                :error-messages="errors.domain"
                dense
                outlined
            />
        </v-col>
        <v-col
            v-if="isEditing"
            cols="12"
        >
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
    import FromProps from "../../../mixins/FormProps"

    export default {
        name: "Company",

        mixins: [
            FromProps
        ],

        data() {
            return {
                owner_email: null,
            }
        },

        computed: {
            showCheckbox() {
                return this.owner_email
                    ? this.owner_email !== this.value.owner_email
                    : false
            },

            selectedText() {
                return (value) => {
                    if (value.email || value.full_name) {
                        return value.full_name
                            ? `${value.email} (${value.full_name})`
                            : value.email
                    }

                    return value
                }

            },

            ...mapGetters({
                users: "companies/owners",
            })
        },

        created() {
            this.$store.dispatch('companies/getMany')

            if (this.isEditing) {
                this.owner_email = this.value.owner_email;
            }
        },
    }
</script>
