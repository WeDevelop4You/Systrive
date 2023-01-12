import Vue from "vue";
import OverviewBase from "../../../../../Support/Store/Base/overviewBase";

import Password from "./password";
import Personal from "./personal";
import TwoFactorAuthentication from "./twoFactorAuthentication";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        view({dispatch}, page) {
            dispatch(
                'page/component',
                app.$api.route('account.settings.overview.page', page)
            )
        },
    },

    modules: {
        page: OverviewBase(),
        navigation: OverviewBase(),

        personal: Personal,
        password: Password,
        twoFactorAuthentication: TwoFactorAuthentication
    }
}
