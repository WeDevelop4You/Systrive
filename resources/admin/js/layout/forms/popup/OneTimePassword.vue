<template>
    <v-row no-gutters>
        <v-otp-input
            v-model="data"
            style="width: 275px"
            class="mx-auto"
            @finish="$emit('action')"
        />
        <error-message :message="errors.one_time_password" />
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import ErrorMessage from "../../../components/ErrorMessage";

    export default {
        name: "OneTimePassword",

        components: {
            ErrorMessage
        },

        computed: {
            data: {
                get() {
                    return this.$store.getters["guest/oneTimePassword"]
                },

                set(value) {
                    this.$store.commit('guest/setOneTimePassword', value)
                }
            },

            ...mapGetters({
                errors: 'guest/errors'
            }),
        }
    }
</script>
