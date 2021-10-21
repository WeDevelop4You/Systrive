<template>
    <v-list-item class="py-0 px-2" color="primary" dense :key="index">
        <v-list-item-icon class="mr-0">
            <v-icon v-text="$vuetify.theme.dark ? 'fas fa-moon' : 'fas fa-sun'"/>
        </v-list-item-icon>
        <v-list-item-content>
            <v-switch class="mt-0 pl-4 pt-0" v-model="$vuetify.theme.dark" hide-details dense :label="$vuetify.lang.t('$vuetify.word.dark_mode')"></v-switch>
        </v-list-item-content>
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
