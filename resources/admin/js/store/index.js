import Vue from 'vue'
import Vuex from 'vuex'

//Modules
import Guest from './modules/guest'
import Popups from "./modules/popups"
import Locale from "./modules/locale"
import User from './modules/auth/user'
import Company from './modules/company'
import Users from './modules/super_admin/users'
import Navigation from "./modules/navigation"
import Permissions from './modules/permissions'
import Companies from './modules/super_admin/companies'
import translations from "./modules/super_admin/translations"

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        user: User,
        guest: Guest,
        users: Users,
        locale: Locale,
        popups: Popups,
        company: Company,
        companies: Companies,
        navigation: Navigation,
        permissions: Permissions,
        translations: translations,
    }
})
