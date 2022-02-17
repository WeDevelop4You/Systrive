<template>
    <v-text-field
        v-model="data"
        :error-messages="errors.recovery_code"
        :class="{'mb-2': !errors.recovery_code}"
        :label="$vuetify.lang.t('$vuetify.word.recovery_code')"
        hide-details="auto"
        outlined
        dense
    />
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "RecoveryCode",

        computed: {
            data: {
                get() {
                    return this.$store.getters["guest/RecoveryCode"]
                },

                set(value) {
                    this.$store.commit('guest/setRecoveryCode', value)
                }
            },

            ...mapGetters({
                errors: 'guest/errors'
            }),
        }
    }
</script>
