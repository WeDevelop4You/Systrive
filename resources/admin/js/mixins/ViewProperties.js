import ViewLayer from "../components/Overviews/Page.vue";

export default {
    components: {
        ViewLayer
    },

    data() {
        return {
            overview: {
                data: {},
                content: {},
                attributes: {},
                identifier: '',
                componentName: '',
            }
        }
    },

    created() {
        this.load()
    },

    methods: {
        load() {
            this.overview.data.route = this.getRoute()
        }
    }
}
