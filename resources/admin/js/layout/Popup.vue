<template>
    <div class="notification-position" :style="{paddingLeft: $vuetify.application.left + 'px'} ">
        <v-row class="mx-4" no-gutters v-for="popup in popups" :key="popup.uuid">
            <v-col cols="12" sm="9" offset-sm="3" md="6" offset-md="6" lg="4" offset-lg="8">
                <component :is="popup.component" :uuid="popup.uuid" :message="popup.message" :dismissible="popup.stayable"></component>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import Simple from '../components/notifications/popup/Simple'

    export default {
        name: "Popup",

        components: {
            Simple,
        },

        computed: {
            ...mapGetters({
                popups: 'notifications/popups'
            })
        }
    }
</script>
