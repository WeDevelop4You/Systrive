import {Fragment} from "vue-fragment";

export default {
    components: {
        Fragment
    },

    methods: {
        clearError(name) {
            if (Object.prototype.hasOwnProperty.call(this.errors, name)) {
                this.errors[name] = undefined
            }
        }
    },
}
