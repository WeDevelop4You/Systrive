import Vue from 'vue'
import Vuex from 'vuex'

//Modules
import Popups from "./modules/popups"
import Locale from "./modules/locale"
import System from "./modules/System"
import Auth from "./modules/User/Auth"
import Company from './modules/Company'
import Guest from "./modules/User/guest"
import Navigation from "./modules/navigation"
import Users from './modules/SuperAdmin/users'
import Permissions from './modules/permissions'
import Companies from './modules/SuperAdmin/companies'
import Registration from "./modules/User/registration"
import Supervisor from "./modules/SuperAdmin/supervisor"
import Translations from "./modules/SuperAdmin/translations"

Vue.use(Vuex)

export default new Vuex.Store({
    actions: {
        initialize({dispatch}) {
            dispatch('user/auth/getOne')
            dispatch('user/auth/getPreferences')
        }
    },

    modules: {
        user: {
            namespaced: true,

            modules: {
                auth: Auth,
                guest: Guest,
                registration: Registration,
            }
        },
        users: Users,
        locale: Locale,
        popups: Popups,
        system: System,
        company: Company,
        companies: Companies,
        supervisor: Supervisor,
        navigation: Navigation,
        permissions: Permissions,
        translations: Translations,
    }
})
