<template>
    <div>
        <v-tooltip
            v-if="item.resend"
            top
        >
            <template #activator="{ on }">
                <v-icon
                    class="mr-2"
                    :disabled="$loading"
                    @click="resendInvite"
                    v-on="on"
                >
                    fas fa-paper-plane
                </v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.invite.resend') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template #activator="{ on }">
                <v-icon
                    class="mr-2"
                    :disabled="$loading"
                    @click="showItem"
                    v-on="on"
                >
                    fas fa-eye
                </v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.show.company') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template #activator="{ on }">
                <v-icon
                    class="mr-2"
                    :disabled="$loading"
                    @click="editItem"
                    v-on="on"
                >
                    fas fa-pen
                </v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.edit.company') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template #activator="{ on }">
                <v-icon
                    class="mr-2"
                    :disabled="$loading"
                    @click="deleteItem"
                    v-on="on"
                >
                    fas fa-trash-alt
                </v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.delete.company') }}</span>
        </v-tooltip>
    </div>
</template>

<script>
    import ActionProps from "../../../../mixins/ActionProps";

    export default {
        name: "Actions",

        mixins: [
            ActionProps
        ],

        methods: {
            async resendInvite() {
                await this.$store.dispatch('companies/resendInvite', this.item.id)

                this.$emit('refresh')
            },

            async showItem() {
                const id = this.item.id

                await this.$store.dispatch('company/getOne', id)

                this.$store.commit('companies/setOverview', id)
            },

            async editItem() {
                const id = this.item.id

                await this.$store.dispatch('companies/getOne', id)
            },

            deleteItem() {
                const item = this.item
                const message = this.$vuetify.lang.t('$vuetify.text.delete.message.company', item.key)

                this.$store.commit('companies/setDelete', {id: item.id, message: message})
            }
        }
    }
</script>
