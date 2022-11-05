import Api from "../providers/Api";
import Auth from "../providers/Auth";
import Import from "../helpers/Import";
import State from "../providers/State";
import Config from "../providers/Config";
import Loader from "../providers/Loader";
import Actions from "../providers/Actions";
import Activity from "../providers/Activity";
import Breadcrumbs from "../providers/Breadcrumbs";
import ModalComponent from "../helpers/Components/ModalComponent";
import NotificationComponent from "../helpers/Components/NotificationComponent";

export default function install(Vue) {
    const app = Import.app(Vue)
    const store = Import.store()

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

    app.$request = Vue.observable({total: 0})
    app.$breadcrumbs = Vue.observable(new Breadcrumbs())

    /**
     *  @param {string} data.redirect
     *  @param {Object} data.popup
     *  @param {Object} data.action
     */
    app.$responseChain = (data) => {
        if (String.prototype.startsWith.call(data, '<script>')) {
            store.dispatch('popups/addPopup', ModalComponent.createDebugger(data))

            return;
        }

        if (Object.prototype.hasOwnProperty.call(data,'redirect')) {
            window.location.href = data.redirect
        }

        if (Object.prototype.hasOwnProperty.call(data,'popup')) {
            let popup = {}

            switch (data.popup.data.type) {
                case 'notification':
                    popup = new NotificationComponent(data.popup)

                    break
                case 'modal':
                    popup = new ModalComponent(data.popup)

                    break
            }

            store.dispatch('popups/addPopup', popup).catch(() => {});
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
