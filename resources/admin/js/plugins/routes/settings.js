import Vuetify from "../vuetify";

const $vuetify = Vuetify.framework

export default [
    {
        path: 'personal',
        name: 'user.setting.personal',
        component: () => import(/* webpackChunkName: "pages/account/settings/personal" */ '../../pages/account/settings/Personal'),
        meta: {
            isAuthenticatedPage: true,
            breadCrumb: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: { name: 'dashboard' }
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.settings'),
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.personal.data'),
                }
            ]
        }
    },
    {
        path: 'security',
        name: 'user.setting.security',
        component: () => import(/* webpackChunkName: "pages/account/settings/security" */ '../../pages/account/settings/Security'),
        meta: {
            isAuthenticatedPage: true,
            breadCrumb: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: { name: 'dashboard' }
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.settings'),
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.security'),
                }
            ]
        }
    }
]
