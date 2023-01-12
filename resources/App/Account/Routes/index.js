import Breadcrumb from "../../../Support/Helpers/Breadcrumb";

export default [
    {
        path: '/',
        alias: '/login',
        name: 'login',
        component: () => import('../Views/Auth.vue'),
        props: {
            route: (app) => app.$api.route('account.login'),
        }
    },{
        path: '/recovery',
        name: 'recovery',
        component: () => import('../Views/Auth.vue'),
        props: {
            route: (app) => app.$api.route('account.recovery'),
        }
    },{
        path: '/reset/:token/:encryptEmail',
        name: 'reset',
        component: () => import('../Views/Auth.vue'),
        props: {
            route: (app) => {
                app.$store.commit('guest/reset/form/setData', {
                    token: app.$route.params.token,
                    encrypt_email: app.$route.params.encryptEmail
                })

                return app.$api.route('account.reset.password')
            },
        }
    },{
        path: '/registration',
        name: 'registration',
        component: () => import('../Views/Auth.vue'),
        props: {
            route: (app) => app.$api.route('account.registration'),
        }
    }, {
        path: '/settings',
        component: () => import('../../../Support/Layout/MinimalLayout.vue'),
        children: [
            {
                path: ':page(personal|security)',
                name: 'settings',
                component: () => import('../Views/Settings.vue'),
                meta: {
                    breadcrumbs: ({app, vuetify}) => app.$breadcrumbs.add(
                        new Breadcrumb(vuetify.lang.t('$vuetify.word.settings'))
                    )
                }
            },
            {
                path: '*',
                redirect: {name: 'settings', params: {page: 'personal'}},
            }
        ]
    }, {
        path: '*',
        redirect: {name: 'login'}
    }
]
