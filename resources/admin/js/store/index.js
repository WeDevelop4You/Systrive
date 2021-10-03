import Vue from 'vue'
import Vuex from 'vuex'

//Modules
import User from './modules/user'
import Roles from './modules/roles'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        user: User,
        roles: Roles,
    }
})
