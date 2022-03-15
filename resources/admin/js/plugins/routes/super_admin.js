import Vuetify from "../vuetify";

const $vuetify = Vuetify.framework

export default [
    {
        path: 'users/:type?/:id?',
        name: 'admin.users',
        component: () => import(/* webpackChunkName: "pages/super_admin/users" */ '../../pages/super_admin/Users'),
        meta: {
            isAuthenticatedPage: true,
            breadCrumb: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: {name: 'dashboard'}
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.sa.sa'),
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.users'),
                }
            ],
        }
    },
    {
        path: 'companies/:type?/:id?',
        name: 'admin.companies',
        component: () => import(/* webpackChunkName: "pages/super_admin/companies" */ '../../pages/super_admin/company'),
        meta: {
            isAuthenticatedPage: true,
            breadCrumb: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: {name: 'dashboard'}
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.sa.sa'),
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.companies'),
                }
            ]
        }
    },
    {
        path: 'translations/:type?/:id?',
        name: 'admin.translations',
        component: () => import(/* webpackChunkName: "pages/super_admin/translations" */ '../../pages/super_admin/Translations'),
        meta: {
            isAuthenticatedPage: true,
            breadCrumb: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: {name: 'dashboard'}
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.sa.sa'),
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.translations'),
                }
            ]
        }
    },
]
