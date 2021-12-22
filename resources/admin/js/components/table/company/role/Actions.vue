<template>
    <div>
        <v-tooltip top>
            <template
                v-if="$auth.can($config.permissions.role.edit)"
                #activator="{ on }"
            >
                <v-icon
                    small
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
                    small
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
            async editItem() {
                const id = this.item.id

                await this.$store.dispatch('company/roles/getOne', id)
            },

            deleteItem() {
                const item = this.item
                const message = this.$vuetify.lang.t('$vuetify.text.delete.message.role', item.name)

                this.$store.commit('company/roles/setDelete', {id: item.id, message: message})
            }
        }
    }
</script>
