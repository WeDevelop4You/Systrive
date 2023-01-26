import MainComponentBase from "./MainComponentBase";
import DataTableBase from "../../Store/Base/dataTableBase";
import SkeletonDataTable from "../../Layout/Skeletons/SkeletonDataTable.vue";
import {throttle as _throttle} from "lodash"
import {Channel} from "laravel-echo";

export default {
    extends: MainComponentBase,

    components: {
        SkeletonDataTable,

        SelectInputComponent: () => import('../Forms/Inputs/SelectInput.vue'),
    },

    data() {
        return {
            search: '',
            sortBy: [],
            channel: null,
            vuexNamespace: this.value.data.vuexNamespace,
            elevation: `elevation-${this.$config.elevation}`,
        }
    },

    computed: {
        headers() {
            return this.$store.getters[`${this.vuexNamespace}/headers`]
        },

        customItems() {
            return this.$store.getters[`${this.vuexNamespace}/customItems`]
        },

        items() {
            return this.$store.getters[`${this.vuexNamespace}/items`]
        },

        total() {
            return this.$store.getters[`${this.vuexNamespace}/total`]
        }
    },

    created() {
        if (!this.$store.hasModule(this.getPath())) {
            this.$store.registerModule(this.getPath(), DataTableBase({
                resetCallback: () => this.resetParams(),
                routes: {
                    items: this.component.data.itemsRoute,
                    headers: this.component.data.headerRoute,
                }
            }))
        }

        this.getHeaders()
        this.getStateLoaded()

        if (this.isset(this.component.data, 'channelRoute')) {
            this.channel = this.$echo.private(this.component.data.channelRoute)

        }
    },

    beforeDestroy() {
        this.$store.unregisterModule(this.getPath())

        if (this.channel instanceof Channel) {
            this.$echo.leave(this.channel.name)
        }
    },

    methods: {
        getPath() {
            return this.vuexNamespace.split('/')
        },

        load() {
            this.getItems().then(() => {
                if (this.channel instanceof Channel) {
                    const throttle = _throttle(this.getItems, 1000, { leading: true })

                    this.channel.listen('.reload', () => {
                        throttle(true).catch(() => {})
                    })
                }
            })
        },

        getItems(silence = false) {
            return this.$store.dispatch(`${this.vuexNamespace}/getItems`, silence)
        },

        getHeaders() {
            return this.$store.dispatch(`${this.vuexNamespace}/getHeaders`)
        },

        getStateLoaded() {
            this.$loader.runStateAction(this.getMainVuexNamespace(this.vuexNamespace))
        }
    }
}
