import Vue from 'vue'
import Vuex from 'vuex'

//Modules
import User from './modules/auth/user'
import Accounts from './modules/admin/accounts'
import Companies from './modules/admin/companies'
import Notifications from "./modules/notifications";
import translations from "./modules/admin/translations";
import Navigation from "./modules/navigation";

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        user: User,
        accounts: Accounts,
        companies: Companies,
        navigation: Navigation,
        translations: translations,
        notifications: Notifications,
    }
})
