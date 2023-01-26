import Vue from "vue";
import {Store, install} from "vuex";

Vue.use(install)

// Modules
import Users from "./Modules/users";
import Company from "./Modules/Company";
import Monitors from "./Modules/monitors";
import Companies from "./Modules/companies";
import Supervisor from "./Modules/supervisor";
import Translations from "./Modules/translations";

export default new Store({
    modules: {
        users: Users,
        company: Company,
        monitors: Monitors,
        companies: Companies,
        supervisor: Supervisor,
        translations: Translations
    }
})
