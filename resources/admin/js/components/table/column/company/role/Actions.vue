<template>
    <div v-if="item.name !== 'Admin'">
        <v-tooltip top>
            <template
                v-if="$auth.can($config.permissions.role.edit)"
                #activator="{ on }"
            >
                <v-icon
                    class="mr-2"
                    :disabled="$loading"
                    @click="editItem"
                    v-on="on"
                >
                    fas fa-pen
                </v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.edit.role') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template
                v-if="$auth.can($config.permissions.role.delete)"
                #activator="{ on }"
            >
                <v-icon
                    class="mr-2"
                    :disabled="$loading"
                    @click="deleteItem"
                    v-on="on"
                >
                    fas fa-trash-alt
                </v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.delete.role') }}</span>
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
            async editItem() {
                const id = this.item.id

                await this.$store.dispatch(`${this.vuexNamespace}/getOne`, id)
            },

            deleteItem() {
                const item = this.item

                this.$store.commit(`${this.vuexNamespace}/setDelete`, {id: item.id, item: item.name})
            }
        }
    }
</script>
