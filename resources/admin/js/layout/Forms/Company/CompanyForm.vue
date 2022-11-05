<template>
    <v-row dense>
        <v-col
            v-if="$auth.can($config.permissions.superAdmin)"
            cols="12"
        >
            <v-text-field
                v-model="data.name"
                :error-messages="errors.name"
                :label="$vuetify.lang.t('$vuetify.word.name')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('name')"
            />
        </v-col>
        <v-col
            v-if="$auth.can($config.permissions.superAdmin)"
            cols="12"
        >
            <v-combobox
                v-model="data.owner"
                :items="users"
                :error-messages="errors.owner"
                :label="$vuetify.lang.t('$vuetify.word.owner')"
                :hide-details="showCheckbox ? true : 'auto'"
                clearable
                dense
                outlined
                @input="clearError('owner')"
            />
        </v-col>
        <v-col
            v-if="isEditing && $auth.can($config.permissions.superAdmin)"
            v-show="showCheckbox"
            cols="12"
        >
            <v-checkbox
                v-model="data.remove_owner"
                :error-messages="errors.owner"
                :label="$vuetify.lang.t('$vuetify.text.remove.owner')"
                dense
                class="mb-2"
                hide-details="auto"
            />
        </v-col>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <v-text-field
                v-model="data.email"
                :error-messages="errors.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('email')"
            />
        </v-col>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <v-text-field
                v-model="data.domain"
                :error-messages="errors.domain"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('domain')"
            />
        </v-col>
        <v-col
            v-if="isEditing"
            cols="12"
        >
            <v-text-field
                v-model="data.domain"
                :error-messages="errors.domain"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('domain')"
            />
        </v-col>
        <v-col
            v-if="$auth.can($config.permissions.superAdmin)"
            cols="12"
        >
            <v-subheader
                class="subtitle-1 px-0"
                style="height: 25px"
                v-text="$vuetify.lang.t('$vuetify.word.modules')"
            />
            <v-row class="my-0">
                <v-col
                    v-for="(module, index) in data.modules"
                    :key="index"
                    class="py-0"
                    cols="auto"
                >
                    <v-checkbox
                        v-model="module.value"
                        :label="module.title"
                        hide-details
                        dense
                    />
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import CustomFormProperties from "../../../mixins/CustomFormProperties"

    export default {
        name: "CompanyForm",

        mixins: [
            CustomFormProperties
        ],

        data() {
            return {
                owner: null,
            }
        },

        computed: {
            showCheckbox() {
                return this.owner
                    ? this.owner?.value !== this.data.owner?.value
                    : false
            },

            ...mapGetters({
                users: "users/list",
            })
        },

        created() {
            this.$store.dispatch('users/list')

            if (this.isEditing) {
                this.owner = this.data.owner;
            }
        },
    }
</script>
