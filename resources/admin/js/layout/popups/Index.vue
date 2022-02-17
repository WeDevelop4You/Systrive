<template>
    <div>
        <v-dialog
            v-model="show"
            :max-width="modal.data.max_width || 500"
            @input="dialogChangeAction($event)"
        >
            <component
                :is="modal.component"
                ref="modal"
                :data="modal.data"
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
    import PromiseChecker from "../../mixins/PromiseChecker";
    
    export default {
        name: "Index",

        components: {
            FormModal: () => import(/* webpackChunkName: "layout/popups/modals/form" */ './modals/Form'),
            ConfirmModal: () => import(/* webpackChunkName: "layout/popups/modals/confirm" */ './modals/Confirm'),
            SimpleNotification: () => import(/* webpackChunkName: "layout/popups/notifications/simple" */ './notifications/Simple'),
        },

        mixins: [
            PromiseChecker
        ],

        computed: {
            show: {
                get () {
                    return this.modal.show || false
                },

                set (value) {
                    this.modal.show = value
                }
            },

            ...mapGetters({
                modal: 'popups/modal',
                notifications: 'popups/notifications'
            })
        },

        methods: {
            dialogChangeAction(value) {
                const action = value
                    ? this.model.data.openAction
                    : this.modal.data.closeAction

                if (action) {
                    const promise = this.callAction(action)

                    if (this.returnIsPromise(promise)) {
                        promise.catch(() => {})
                    }
                }
            }
        }
    }
</script>
