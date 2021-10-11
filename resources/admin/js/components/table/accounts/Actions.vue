<template>
    <div>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
                <v-icon small class="mr-2" @click="editItem()" v-on="on" :disabled="$loading">fas fa-pen</v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.edit.account') }}</span>
        </v-tooltip>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
                <v-icon small class="mr-2" @click="deleteItem()" v-on="on" :disabled="$loading">fas fa-trash-alt</v-icon>
            </template>
            <span>{{ $vuetify.lang.t('$vuetify.word.delete.account') }}</span>
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
                this.$store.commit('accounts/setAccount', this.item)
            }
        }
    }
</script>
