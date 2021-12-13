<template>
    <v-row no-gutters>
        <v-col cols="12">
            <v-text-field
                v-model="value.first_name"
                :error-messages="errors.first_name"
                :class="{'pb-2': !errors.first_name}"
                :label="$vuetify.lang.t('$vuetify.word.first_name')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.middle_name"
                :error-messages="errors.middle_name"
                :class="{'pb-2': !errors.middle_name}"
                :label="$vuetify.lang.t('$vuetify.word.middle_name')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="value.last_name"
                :error-messages="errors.last_name"
                :class="{'pb-2': !errors.last_name}"
                :label="$vuetify.lang.t('$vuetify.word.last_name')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-select
                v-model="value.gender"
                :items="$config.genders"
                :error-messages="errors.gender"
                :class="{'pb-2': !errors.gender}"
                :label="$vuetify.lang.t('$vuetify.word.gender')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-menu
                v-model="dateMenu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="auto"
            >
                <template #activator="{ on, attrs }">
                    <v-text-field
                        v-model="value.birth_date"
                        :error-messages="errors.birth_date"
                        :class="{'pb-2': !errors.birth_date}"
                        :label="$vuetify.lang.t('$vuetify.word.birth_date')"
                        dense
                        readonly
                        outlined
                        hide-details="auto"
                        v-bind="attrs"
                        v-on="on"
                    />
                </template>
                <v-date-picker
                    v-model="value.birth_date"
                    :max="maxDate"
                    no-title
                    @input="dateMenu = false"
                />
            </v-menu>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "UserProfile",

        props: {
            value: {
                required: true,
                type: Object,
            },

            errors: {
                required: true,
                type: Object,
            },
        },

        data() {
            return {
                dateMenu: false,
                maxDate: new Date().toISOString().slice(0,10),
            }
        },
    }
</script>
