import Component from "../Helpers/Components/Component";
import ViewLayer from "../Components/Overviews/Page.vue";

export default {
    components: {
        ViewLayer
    },

    data() {
        return {
            overview: new Component({})
        }
    },

    created() {
        this.load()
    },

    methods: {
        load() {
            this.overview.data.route = this.getRoute
        }
    }
}
