<template>
    <div>
        <v-tooltip top>
            <template #activator="{ on }">
                <v-icon
                    small
                    class="mr-2"
                    :disabled="$loading"
                    @click="editItem(true)"
                    v-on="on"
                >
                    fas fa-building
                </v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.show.company') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template #activator="{ on }">
                <v-icon
                    small
                    class="mr-2"
                    :disabled="$loading"
                    @click="editItem()"
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
                    small
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
            async editItem(show = false) {
                const id = this.item.id
                const type = show ? 'show' : 'edit'

                await this.$router.replace({name: this.$route.name, params: {type: type, id: id}})

                await this.$store.dispatch('companies/getOne', {id: id, showDialog: show})
            },

            deleteItem() {
                const item = this.item
                const message = this.$vuetify.lang.t('$vuetify.text.delete.message.companies', item.key)

                this.$store.commit('companies/setDelete', {id: item.id, message: message})
            }
        }
    }
</script>
