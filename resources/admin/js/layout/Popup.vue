<template>
    <div>
        <v-dialog
            v-model="show"
            persistent
        >
            <component
                :is="modal.component"
                :data="modal.data"
                @close="modal.show = false"
            />
        </v-dialog>
        <div
            class="notification-position"
            :style="{paddingLeft: $vuetify.application.left + 'px'} "
        >
            <v-row
                v-for="item in notifications"
                :key="item.uuid"
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
                        :is="item.component"
                        :data="item.data"
                    />
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Popup",

        components: {
            FormModal: () => import(/* webpackChunkName: "components/popups/modals/form" */ '../components/popups/modals/Form'),
            ConfirmModal: () => import(/* webpackChunkName: "components/popups/modals/confirm" */ '../components/popups/modals/Confirm'),
            SimpleNotification: () => import(/* webpackChunkName: "components/popups/notifications/simple" */ '../components/popups/notifications/Simple'),
        },

        computed: {
            show() {
                return this.modal.show || false
            },

            ...mapGetters({
                modal: 'popups/modal',
                notifications: 'popups/notifications'
            })
        }
    }
</script>
