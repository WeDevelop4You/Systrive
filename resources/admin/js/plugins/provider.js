import Api from "../Providers/Api";
import Auth from "../Providers/Auth";
import Config from "../Providers/Config";
import Loader from "../Providers/Loader";
import State from "../Providers/State";
import Actions from "../Providers/Actions";
import Helper from "../Providers/Helper";
import Activity from "../Providers/Activity";

export default function install(Vue) {
    const app = Helper.getApp(Vue)
    const store = Helper.getStore()

    // Load order for providers
    //
    // First load the api helper
    app.$api = new Api('admin')

    // Then load the base
    app.$config = new Config()
    app.$activity = new Activity()
    app.$auth = new Auth()
    app.$loader = new Loader()
    app.$state = new State()
    app.$actions = new Actions()

    app.$request = Vue.observable({
        total: 0
    })

    app.$responseChain = (data) => {
        if (Object.prototype.hasOwnProperty.call(data,'redirect')) {
            window.location.href = data.redirect
        }

        if (Object.prototype.hasOwnProperty.call(data,'popup')) {
            store.dispatch('popups/addPopup', data.popup).catch(() => {});
        }

        if (Object.prototype.hasOwnProperty.call(data, 'action')) {
            app.$actions.call(data.action)
        }
    }

    Vue.mixin({
        computed: {
            $loading() {
                return !!this.$request.total
            },

            genders() {
                return this.$config.genders()
            }
        }
    })
}
