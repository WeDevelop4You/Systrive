<template>
    <div>
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
            <span>{{ $vuetify.lang.t('$vuetify.word.edit.user') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template #activator="{ on }">
                <v-hover v-slot="{ hover }">
                    <v-icon
                        class="mr-2"
                        :disabled="$loading"
                        :color="hover ? 'error' : ''"
                        @click="deleteItem"
                        v-on="on"
                    >
                        fas fa-trash-alt
                    </v-icon>
                </v-hover>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.delete.user') }}</span>
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
            editItem() {
                this.$store.dispatch('users/getOne', {id: this.item.id})
            },

            deleteItem() {
                const item = this.item
                const message = this.$vuetify.lang.t('$vuetify.text.delete.message.user', item.email)

                this.$store.commit('users/setDelete', {id: item.id, message: message, hideDelete: item.deleted_at})
            }
        }
    }
</script>
