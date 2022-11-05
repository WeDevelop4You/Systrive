<template>
    <v-row dense>
        <v-col cols="12">
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
            v-if="!isEditing"
            cols="12"
        >
            <v-text-field
                v-model="data.database"
                :counter="counter(64)"
                :hint="prefix + (data.database ?? '')"
                :error-messages="errors.database"
                :maxlength="counter(64)"
                :label="$vuetify.lang.t('$vuetify.word.database.name')"
                dense
                outlined
                persistent-hint
                hide-details="auto"
                @input="clearError('database')"
            />
        </v-col>
        <v-col
            v-if="!isEditing"
            cols="12"
        >
            <v-combobox
                v-model="data.username"
                :items="databases"
                :counter="counter(32)"
                :maxlength="counter(32)"
                :hint="fullUsername"
                :error-messages="errors.username"
                :label="$vuetify.lang.t('$vuetify.word.username')"
                clearable
                dense
                outlined
                persistent-hint
                hide-details="auto"
                @input="change"
            />
        </v-col>
        <v-col
            v-if="!isEditing"
            v-show="needsPassword"
            cols="12"
        >
            <v-text-field
                v-model="data.password"
                :error-messages="errors.password"
                :type="show ? 'text' : 'password'"
                :label="$vuetify.lang.t('$vuetify.word.password.password')"
                :append-icon="show ? 'fas fa-eye' : 'fas fa-eye-slash'"
                dense
                outlined
                hide-details="auto"
                @click:append="show = !show"
                @input="clearError('password')"
            />
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import CustomFormProperties from "../../../../mixins/CustomFormProperties";

    export default {
        name: "CmsForm",

        mixins: [
            CustomFormProperties
        ],

        data() {
            return {
                show: false,
                fullUsername: '',
                needsPassword: true
            }
        },

        computed: {
            prefix() {
                return `${this.data.system}_`
            },

            ...mapGetters({
                databases: "company/cms/list",
            })
        },

        created() {
            this.$store.dispatch('company/cms/list')

            this.username(this.data.username)
        },

        methods: {
            counter(value) {
                return value - this.prefix.length
            },

            change(value) {
                this.username(value)
                this.clearError('username')
            },

            username(value) {
                const condition = typeof value === 'string' || value === null
                const username = condition ? (this.data.username ?? '') : this.data.username.text

                this.needsPassword = condition
                this.fullUsername = this.prefix + username
            }
        }
    }
</script>
