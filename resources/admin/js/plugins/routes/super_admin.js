import Helper from "../../Providers/Helper";
import {STATE_ALL, STATE_EDIT} from "../../Providers/Config";

const $api = Helper.getApi()
const $vuetify = Helper.getVuetify()

export default [
    {
        path: 'users/:chapters*',
        name: 'admin.users',
        component: () => import(/* webpackChunkName: "components/overviews/page" */ '../../components/Overviews/Page'),
        props: {
            value: {
                data: {
                    route: $api.route('admin.user.overview')
                }
            }
        },
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs: [
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
        path: 'companies/:chapters*',
        name: 'admin.companies',
        component: () => import(/* webpackChunkName: "pages/super_admin/companies" */ '../../pages/SuperAdmin/Companies'),
        meta: {
            isAuthenticatedPage: true,
            allowedStates: STATE_ALL,
            breadcrumbs: [
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
        path: 'translations/:chapters*',
        name: 'admin.translations',
        component: () => import(/* webpackChunkName: "components/overviews/page" */ '../../components/Overviews/Page'),
        props: {
            value: {
                data: {
                    route: $api.route('admin.translation.overview')
                }
            }
        },
        meta: {
            isAuthenticatedPage: true,
            allowedStates: [STATE_EDIT],
            breadcrumbs: [
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
            ],
        }
    },
    {
        path: 'supervisor/:chapters*',
        name: 'admin.supervisor',
        component: () => import(/* webpackChunkName: "components/overviews/page" */ '../../components/Overviews/Page'),
        props: {
            value: {
                data: {
                    runLoader: 'supervisor',
                    vuexNamespace: 'supervisor/overview',
                    callbackDelay: 1000 * 60 * 10, // 10 minutes
                    route: $api.route('admin.supervisor.overview'),
                }
            }
        },
        meta: {
            isAuthenticatedPage: true,
            allowedStates: STATE_ALL,
            breadcrumbs: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: {name: 'dashboard'}
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.sa.sa'),
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.supervisor'),
                }
            ]
        }
    },
    {
        path: 'jobs/:chapters*',
        name: 'admin.jobs',
        component: () => import(/* webpackChunkName: "components/overviews/page" */ '../../components/Overviews/Page'),
        props: {
            value: {
                data: {
                    route: $api.route('admin.job.overview'),
                }
            }
        },
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: {name: 'dashboard'}
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.sa.sa'),
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.jobs'),
                }
            ]
        }
    },
]
