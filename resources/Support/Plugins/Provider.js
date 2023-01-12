import Config from "../Providers/Config";
import Actions from "../Providers/Actions";
import DialogComponent from "../Helpers/Components/DialogComponent";
import NotificationComponent from "../Helpers/Components/NotificationComponent";

export default function install(vue, options) {
    const app = vue.prototype
    const store = options.store
    const router = options.router
    const loader = options.loader

    // Default providers
    app.$config = new Config()
    app.$actions = new Actions(store, router)
    app.$request = vue.observable({total: 0})

    // Loader per domain
    loader.call(this)

    /**
     *  @param {string} data.redirect
     *  @param {Object} data.popup
     *  @param {Object} data.action
     */
    app.$responseChain = (data) => {
        if (String.prototype.startsWith.call(data, '<script>')) {
            store.dispatch('popups/addPopup', DialogComponent.createDebugger(data))

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
                    popup = new DialogComponent(data.popup)

                    break
            }

            store.dispatch('popups/addPopup', popup).catch(() => {});
        }

        if (Object.prototype.hasOwnProperty.call(data, 'action')) {
            app.$actions.call(data.action)
        }
    }

    app.isset = (data, key) => {
        return Object.prototype.hasOwnProperty.call(data, key)
    }

    app.getMainVuexNamespace = (VuexNamespace) => {
        return VuexNamespace.substring(0, VuexNamespace.lastIndexOf('/'))
    }

    vue.mixin({
        computed: {
            $loading() {
                return !!this.$request.total
            }
        }
    })
}
