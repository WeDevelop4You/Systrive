import MainComponentBase from "./MainComponentBase";
import SkeletonDataTable from "../../Layout/Skeletons/SkeletonDataTable.vue";
import {Channel} from "laravel-echo";
import {throttle as _throttle} from "lodash"

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
        this.setup()

        this.unwatch = this.$store.watch(
            (state, getters) => getters[`${this.vuexNamespace}/status`],
            (status) => {if (status === 'reset_params') this.resetParams()},
        );

        this.$loader.runStateAction(this.getMainVuexNamespace(this.vuexNamespace))
    },

    methods: {
        setup() {
            this.$store.commit(`${this.vuexNamespace}/setRoutes`, {
                items: this.component.data.itemsRoute,
                headers: this.component.data.headerRoute,
            })

            this.$store.dispatch(`${this.vuexNamespace}/getHeaders`)

            if (this.isset(this.component.data, 'channelRoute')) {
                this.channel = this.$echo.private(this.component.data.channelRoute)
            }
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
        }
    },

    beforeDestroy() {
        this.unwatch();

        this.$store.commit(`${this.vuexNamespace}/reset`)

        if (this.channel instanceof Channel) {
            this.$echo.leave(this.channel.name)
        }
    }
}
