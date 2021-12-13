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
    import Confirm from "../components/popups/modals/Confirm";
    import Simple from '../components/popups/notifications/Simple'

    export default {
        name: "Popup",

        components: {
            Simple,
            Confirm,
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
