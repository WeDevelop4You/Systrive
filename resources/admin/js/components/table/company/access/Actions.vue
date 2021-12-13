<template>
    <div>
        <v-tooltip top>
            <template #activator="{ on }">
                <v-icon
                    v-can="'user.edit_roles'"
                    small
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
            v-if="!item.isOwner"
            top
        >
            <template #activator="{ on }">
                <v-hover v-slot="{ hover }">
                    <v-icon
                        v-can="'user.revoke'"
                        small
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
    export default {
        name: "Actions",

        props: {
            item: {
                required: true,
                type: Object
            },

            isMobile: {
                required: true,
                type: Boolean
            },

            header: {
                required: true,
                type: Object
            },

            index: {
                required: true,
                type: Number
            }
        },

        methods: {
            editItem() {
                this.$store.dispatch('company/users/getOne',  this.item.id)
            },

            deleteItem() {
                const item = this.item
                const message = this.$vuetify.lang.t('$vuetify.text.delete.message.revoke.user', item.email)

                this.$store.commit('company/users/setDelete', {id: item.id, message: message, hideDelete: item.deleted_at})
            }
        },
    }
</script>
