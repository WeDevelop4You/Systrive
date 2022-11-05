<template>
    <v-row dense>
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
                autofocus
                type="email"
                hide-details="auto"
                @input="clearError('email')"
            />
        </v-col>
        <v-col :cols="registration ? 12 : 8">
            <v-text-field
                v-model="data.first_name"
                :error-messages="errors.first_name"
                :label="$vuetify.lang.t('$vuetify.word.first_name')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('first_name')"
            />
        </v-col>
        <v-col :cols="registration ? 12 : 4">
            <v-text-field
                v-model="data.middle_name"
                :error-messages="errors.middle_name"
                :label="$vuetify.lang.t('$vuetify.word.middle_name')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="data.last_name"
                :error-messages="errors.last_name"
                :label="$vuetify.lang.t('$vuetify.word.last_name')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('last_name')"
            />
        </v-col>
        <v-col :cols="registration ? 12 : 6">
            <v-select
                v-model="data.gender"
                :items="genders"
                :error-messages="errors.gender"
                :label="$vuetify.lang.t('$vuetify.word.gender')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('gender')"
            />
        </v-col>
        <v-col :cols="registration ? 12 : 6">
            <v-menu
                v-model="dateMenu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="auto"
            >
                <template #activator="{ on, attrs }">
                    <v-text-field
                        v-model="data.birth_date"
                        v-bind="attrs"
                        :error-messages="errors.birth_date"
                        :label="$vuetify.lang.t('$vuetify.word.birth_date')"
                        dense
                        readonly
                        outlined
                        type="date"
                        hide-details="auto"
                        v-on="on"
                    />
                </template>
                <v-date-picker
                    v-model="data.birth_date"
                    :max="maxDate"
                    no-title
                    color="primary"
                    @input="datePickerClose"
                />
            </v-menu>
        </v-col>
    </v-row>
</template>

<script>
    import CustomFormProperties from "../../mixins/CustomFormProperties";

    export default {
        name: "UserProfileForm",

        mixins: [
            CustomFormProperties
        ],

        props: {
            registration: {
                default: false,
                type: Boolean
            }
        },

        data() {
            return {
                dateMenu: false,
                maxDate: new Date().toISOString().slice(0,10),
            }
        },

        methods: {
            datePickerClose() {
                this.dateMenu = false
                this.clearError('birth_date')
            }
        }
    }
</script>
