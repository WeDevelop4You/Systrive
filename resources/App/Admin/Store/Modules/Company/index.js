import Cms from "./cms";
import Users from "../../../../../Support/Store/Modules/Company/users";
import Roles from "../../../../../Support/Store/Modules/Company/roles";

export default {
    namespaced: true,

    state: () => ({
        id: null,
    }),

    mutations: {
        initialize(state, data) {
            state.id = data.id
        }
    },

    getters: {
        id(state) {
            return state.id
        }
    },

    modules: {
        cms: Cms,
        users: Users,
        roles: Roles
    }
}
