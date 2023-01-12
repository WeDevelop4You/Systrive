import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex)

// Modules
import Locales from "./Modules/locales";
import Settings from "./Modules/Settings";
import Login from "./Modules/Guest/login";
import Reset from "./Modules/Guest/reset";
import Recovery from "./Modules/Guest/recovery";
import Registration from "./Modules/Guest/registration";

import Auth from "../../../Support/Store/Modules/auth";
import Popups from "../../../Support/Store/Modules/popups";
import Locale from "../../../Support/Store/Modules/locale";
import Navigation from "../../../Support/Store/Modules/navigation";

export default new Vuex.Store({
    modules: {
        auth: Auth,
        locale: Locale,
        popups: Popups,
        locales: Locales,
        settings: Settings,
        navigation: Navigation,

        guest: {
            namespaced: true,

            modules: {
                login: Login,
                reset: Reset,
                recovery: Recovery,
                registration: Registration,
            }
        },
    }
})
