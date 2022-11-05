import Import from "../helpers/Import";
import Breadcrumb from "../helpers/Breadcrumb";
import {STATE_ALL, STATE_EDIT} from "../config/RouteState";

const app = Import.app()
const $api = Import.api()
const $vuetify = Import.vuetify()

export default [
    {
        path: 'users/:chapters*',
        name: 'admin.users',
        component: () => import('../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: $api.route('admin.user.overview')
                }
            }
        },
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs() {
                app.$breadcrumbs.setSuperAdmin()
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.users')))
            }
        }
    },
    {
        path: 'companies/:chapters*',
        name: 'admin.companies',
        component: () => import('../views/SuperAdmin/Companies.vue'),
        meta: {
            isAuthenticatedPage: true,
            allowedStates: STATE_ALL,
            breadcrumbs() {
                app.$breadcrumbs.setSuperAdmin()
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.companies')))
            }
        }
    },
    {
        path: 'translations/:chapters*',
        name: 'admin.translations',
        component: () => import('../components/Overviews/Page.vue'),
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
            breadcrumbs() {
                app.$breadcrumbs.setSuperAdmin()
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.translations')))
            }
        }
    },
    {
        path: 'supervisor/:chapters*',
        name: 'admin.supervisor',
        component: () => import('../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    loadState: 'supervisor',
                    refreshDelay: 1000 * 60 * 10, // every 10 minutes
                    vuexNamespace: 'supervisor/overview',
                    route: $api.route('admin.supervisor.overview'),
                }
            }
        },
        meta: {
            isAuthenticatedPage: true,
            allowedStates: STATE_ALL,
            breadcrumbs() {
                app.$breadcrumbs.setSuperAdmin()
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.supervisor')))
            }
        }
    },
    {
        path: 'jobs/:chapters*',
        name: 'admin.jobs',
        component: () => import('../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: $api.route('admin.job.schedule.overview'),
                }
            }
        },
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs() {
                app.$breadcrumbs.setSuperAdmin()
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.jobs')))
            }
        }
    },
]
