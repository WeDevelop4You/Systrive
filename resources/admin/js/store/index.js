import Vue from 'vue'
import Vuex from 'vuex'

//Modules
import User from './modules/auth/user'
import Users from './modules/admin/users'
import Company from './modules/company'
import Permissions from './modules/permissions'
import Companies from './modules/admin/companies'
import Notifications from "./modules/notifications";
import translations from "./modules/admin/translations";
import Navigation from "./modules/navigation";

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        user: User,
        users: Users,
        company: Company,
        companies: Companies,
        navigation: Navigation,
        permissions: Permissions,
        translations: translations,
        notifications: Notifications,
    }
})
