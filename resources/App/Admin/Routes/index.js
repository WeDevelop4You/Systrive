import Breadcrumb from "../../../Support/Helpers/Breadcrumb";
import {STATE_ALL, STATE_EDIT} from "../../../Support/Config/RouteState";

export default [
    {
        path: '/dashboard',
        alias: '/',
        name: 'dashboard',
        component: () => import('../../../App/Admin/Views/Dashboard.vue'),
        meta: {
            breadcrumbs: ({app}) => app.$breadcrumbs.setDashboard()
        }
    }, {
        path: '/users/:chapters*',
        name: 'admin.users',
        component: () => import('../../../Support/components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({app}) => app.$api.route('admin.user.overview')
                }
            }
        },
        meta: {
            breadcrumbs: ({app, vuetify}) => app.$breadcrumbs.setDashboard()
                .add(new Breadcrumb(vuetify.lang.t('$vuetify.word.users')))
        }
    }, {
        path: '/companies/:chapters*',
        name: 'admin.companies',
        component: () => import('../../../App/Admin/Views/Companies.vue'),
        meta: {
            allowedStates: STATE_ALL,
            breadcrumbs: ({app, vuetify}) => app.$breadcrumbs.setDashboard()
                .add(new Breadcrumb(vuetify.lang.t('$vuetify.word.companies')))

        }
    }, {
        path: '/translations/:chapters*',
        name: 'admin.translations',
        component: () => import('../../../Support/components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({app}) => app.$api.route('admin.translation.overview')
                }
            }
        },
        meta: {
            allowedStates: [STATE_EDIT],
            breadcrumbs: ({app, vuetify}) => app.$breadcrumbs.setDashboard()
                .add(new Breadcrumb(vuetify.lang.t('$vuetify.word.translations')))
        }
    }, {
        path: '/monitor',
        name: 'admin.monitor',
        component: () => import('../../../Support/components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({app}) => app.$api.route('admin.monitor.overview')
                }
            }
        },
        meta: {
            allowedStates: [STATE_EDIT],
            breadcrumbs: ({app, vuetify}) => app.$breadcrumbs.setDashboard()
                .add(new Breadcrumb(vuetify.lang.t('$vuetify.word.monitor')))
        }
    }, {
        path: '/supervisor/:chapters*',
        name: 'admin.supervisor',
        component: () => import('../../../Support/components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    loadState: 'supervisor',
                    refreshDelay: 1000 * 60 * 10, // every 10 minutes
                    vuexNamespace: 'supervisor/overview',
                    route: ({app}) => app.$api.route('admin.supervisor.overview'),
                }
            }
        },
        meta: {
            allowedStates: STATE_ALL,
            breadcrumbs: ({app, vuetify}) => app.$breadcrumbs.setDashboard()
                .add(new Breadcrumb(vuetify.lang.t('$vuetify.word.supervisor')))
        }
    }, {
        path: '*',
        redirect: {name: 'dashboard'},
    }
]
