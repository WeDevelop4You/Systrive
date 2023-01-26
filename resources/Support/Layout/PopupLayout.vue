<template>
    <div>
        <template v-for="(modal, index) in modals">
            <Dialog
                :key="index"
                :value="modal"
            />
        </template>
        <div
            class="notification-position"
            :style="{paddingLeft: $vuetify.application.left + 'px'} "
        >
            <v-row
                v-for="(notification, index) in notifications"
                :key="index"
                class="mx-4"
                no-gutters
            >
                <v-col
                    cols="12"
                    sm="9"
                    offset-sm="3"
                    md="6"
                    offset-md="6"
                    lg="4"
                    offset-lg="8"
                >
                    <component
                        :is="notification.componentName"
                        :value="notification"
                    />
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import Dialog from "../Components/Popups/Dialog.vue";

    export default {
        name: "Popups",

        components: {
            Dialog,
            SimpleNotificationComponent: () => import('../Components/Popups/Notifications/Simple.vue'),
        },

        computed: {
            ...mapGetters({
                modals: 'popups/modals',
                notifications: 'popups/notifications'
            })
        }
    }
</script>
