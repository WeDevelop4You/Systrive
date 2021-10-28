<template>
    <v-list-item class="py-0 px-2" color="primary" dense :key="index">
        <v-list-item-icon class="mr-4">
            <v-icon dense v-text="$vuetify.theme.dark ? 'fas fa-moon' : 'fas fa-sun'"/>
        </v-list-item-icon>
        <v-list-item-content style="padding-bottom: 10px">
            <v-list-item-title v-text="$vuetify.lang.t('$vuetify.word.dark_mode')"></v-list-item-title>
        </v-list-item-content>
        <v-list-item-action class="my-2">
            <v-switch class="mt-0 pt-0" v-model="$vuetify.theme.dark" hide-details dense></v-switch>
        </v-list-item-action>
    </v-list-item>
</template>

<script>
    export default {
        name: "DarkModeSwitchList",

        props: {
            index: {
                required: true,
                type: Number
            }
        }
    }
</script>

<style scoped>

</style>
