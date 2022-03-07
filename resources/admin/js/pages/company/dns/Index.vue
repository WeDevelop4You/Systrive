<template>
    <v-row>
        <v-col cols="12">
            <details-card
                v-model="test"
                :title="$vuetify.lang.t('$vuetify.details')"
            >
                <template #edit>
                    <create-or-edit-modal
                        v-model="modal"
                        title="test"
                        button-type="icon"
                    >
                        <template #button>
                            <v-btn
                                icon
                                :disabled="$loading"
                                @click="modal = true"
                            >
                                <v-icon>fas fa-pen</v-icon>
                            </v-btn>
                        </template>
                        abdawbd
                    </create-or-edit-modal>
                </template>
            </details-card>
        </v-col>
    </v-row>
</template>

<script>
    import DetailsCard from "../../../components/cards/DetailsCard";
    import CreateOrEditModal from "../../../components/modals/CreateOrEditModal";
    import {mapGetters} from "vuex";

    export default {
        name: "Index",

        components: {
            DetailsCard,
            CreateOrEditModal
        },

        beforeRouteUpdate(to, from, next) {
            this.$store.commit('company/system/dns/reset')

            this.setup(to.params.domainNameServer)

            next()
        },

        data() {
            return {
                modal: false,
                test: []
            }
        },

        computed: {
            ...mapGetters({

            })
        },

        created() {
            this.setup(this.$route.params.domainNameServer)
        },

        methods: {
            setup(dns) {
                this.$store.dispatch('company/system/dns/search', dns)
            }
        }
    }
</script>
