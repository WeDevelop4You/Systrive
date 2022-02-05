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
            <span>{{ $vuetify.lang.t('$vuetify.word.edit.translation') }}</span>
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
            <span>{{ $vuetify.lang.t('$vuetify.word.delete.translation') }}</span>
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
            async editItem() {
                await this.$store.dispatch('translations/getOne', this.item.id)
            },

            deleteItem() {
                const item = this.item
                const message = this.$vuetify.lang.t('$vuetify.text.delete.message.translation', item.key)

                this.$store.commit('translations/setDelete', {id: item.id, message: message})
            }
        }
    }
</script>
