<template>
    <div>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
                <v-icon small class="mr-2" @click="editItem" v-on="on" :disabled="$loading">fas fa-pen</v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.edit.translation') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
                <v-icon small class="mr-2" @click="deleteItem" v-on="on" :disabled="$loading">fas fa-trash-alt</v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.delete.translation') }}</span>
        </v-tooltip>
    </div>
</template>

<script>
    export default {
        name: "Actions",

        props: {
            item: {
                required: true,
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
                this.$store.dispatch('translations/getOne', this.item.id)
            },

            deleteItem() {
                const item = this.item
                const message = this.$vuetify.lang.t('$vuetify.text.delete.message.translation', item.key)

                this.$store.commit('translations/setDelete', {id: item.id, message: message})
            }
        }
    }
</script>
