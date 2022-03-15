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
                await this.$store.dispatch(`${this.vuexNamespace}/getOne`, this.item.id)
            },

            deleteItem() {
                const item = this.item

                this.$store.commit(`${this.vuexNamespace}/setDelete`, {id: item.id, item: item.key})
            }
        }
    }
</script>
