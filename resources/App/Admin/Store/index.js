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

import Auth from "../../../Support/Store/Modules/auth";
import Popups from "../../../Support/Store/Modules/popups";
import Locale from "../../../Support/Store/Modules/locale";
import Navigation from "../../../Support/Store/Modules/navigation";


export default new Store({
    modules: {
        auth: Auth,
        users: Users,
        locale: Locale,
        popups: Popups,
        company: Company,
        monitors: Monitors,
        companies: Companies,
        navigation: Navigation,
        supervisor: Supervisor,
        translations: Translations
    }
})
