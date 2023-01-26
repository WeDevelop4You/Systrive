import Vue from "vue";
import {Store, install} from "vuex";

Vue.use(install)

// Modules
import Locales from "./Modules/locales";
import Settings from "./Modules/Settings";
import Login from "./Modules/Guest/login";
import Reset from "./Modules/Guest/reset";
import Recovery from "./Modules/Guest/recovery";
import Registration from "./Modules/Guest/registration";

export default new Store({
    modules: {
        locales: Locales,
        settings: Settings,

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
