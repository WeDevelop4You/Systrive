<template>
    <div>
        <v-tooltip
            v-if="item.resend && $auth.can($config.permissions.user.invite)"
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
        <v-tooltip
            v-if="$auth.can($config.permissions.user.editRoles)"
            top
        >
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
            <span>{{ $vuetify.lang.t('$vuetify.word.edit.user') }}</span>
        </v-tooltip>
        <v-tooltip
            v-if="!item.isOwner && $auth.can($config.permissions.user.revoke)"
            top
        >
            <template #activator="{ on }">
                <v-hover v-slot="{ hover }">
                    <v-icon
                        class="mr-2"
                        :disabled="$loading"
                        :color="hover ? 'error' : ''"
                        @click="deleteItem"
                        v-on="on"
                    >
                        fas fa-user-minus
                    </v-icon>
                </v-hover>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.revoke.user') }}</span>
        </v-tooltip>
    </div>
</template>

<script>
    import ActionProps from "../../../../../mixins/ActionProps";

    export default {
        name: "Actions",

        mixins: [
            ActionProps
        ],

        methods: {
            async resendInvite() {
                await this.$store.dispatch(`${this.vuexNamespace}/resendInvite`, this.item.id)

                this.$emit('refresh')
            },

            editItem() {
                this.$store.dispatch(`${this.vuexNamespace}/getOne`,  this.item.id)
            },

            deleteItem() {
                const item = this.item

                this.$store.commit(`${this.vuexNamespace}/setDelete`, {id: item.id, item: item.email, hideButton: item.deleted_at})
            }
        },
    }
</script>
