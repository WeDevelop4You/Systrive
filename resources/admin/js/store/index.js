import Vue from 'vue'
import Vuex from 'vuex'

//Modules
import User from './modules/auth/user'
import Accounts from './modules/accounts'
import Notifications from "./modules/notifications";
import translations from "./modules/translations";

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        user: User,
        accounts: Accounts,
        translations: translations,
        notifications: Notifications,
    }
})
