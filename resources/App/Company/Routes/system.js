import {STATE_CREATE} from "../../../Support/Config/RouteState";

export default [
    {
        path: 'd/:name/:chapters*',
        name: 'system.domain',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({app, route}) => app.systemRoute('system.domain.search', route.params.name),
                    updateOnRouteChange: (to, from) => to.params.name !== from.params.name
                }
            }
        },
        meta: {
            page: 'company',
            allowedStates: STATE_CREATE,
            breadcrumbs: ({app, vuetify, route}) => app.$breadcrumbs.setSystem(route, vuetify.lang.t('$vuetify.word.domain.domain'))
        },
    },
    {
        path: 'dns/:name',
        name: 'system.dns',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    vuexNamespace: 'company/system/dns/overview',
                    route: ({app, route}) => app.$api.systemRoute('system.dns.search', route.params.name),
                    updateOnRouteChange: (to, from) => to.params.name !== from.params.name
                }
            }
        },
        meta: {
            page: 'company',
            breadcrumbs: ({app, vuetify, route}) => app.$breadcrumbs.setSystem(route, vuetify.lang.t('$vuetify.word.dns.dns'))
        },
    },
    {
        path: 'db/:name',
        name: 'system.database',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    vuexNamespace: 'company/system/database/overview',
                    route: ({app, route}) => app.$api.systemRoute('system.database.search', route.params.name),
                    updateOnRouteChange: (to, from) => to.params.name !== from.params.name
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs: ({app, vuetify, route}) => app.$breadcrumbs.setSystem(route, vuetify.lang.t('$vuetify.word.database.database'))

        },
    },
    {
        path: 'm/:name',
        name: 'system.mail',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    vuexNamespace: 'company/system/mailDomain/overview',
                    route: ({app, route}) => app.$api.systemRoute('system.mail.domain.search', route.params.name),
                    updateOnRouteChange: (to, from) => to.params.name !== from.params.name
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs: ({app, vuetify, route}) => app.$breadcrumbs.setSystem(route, vuetify.lang.t('$vuetify.word.mail.domain'))
        },
    },
]
