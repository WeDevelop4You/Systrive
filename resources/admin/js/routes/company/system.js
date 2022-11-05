import Import from "../../helpers/Import";
import {STATE_CREATE} from "../../config/RouteState";

const app = Import.app()
const $api = Import.api()
const $vuetify = Import.vuetify()

export default [
    {
        path: 'd/:name/:chapters*',
        name: 'company.system.domain',
        component: () => import('../../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({route}) => {
                        return $api.systemRoute('system.domain.search', route.params.name)
                    },
                    updateOnRouteChange: (to, from) => {
                        return to.params.name !== from.params.name
                    }
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            allowedStates: STATE_CREATE,
            breadcrumbs(route) {
                app.$breadcrumbs.setCompanySystem(
                    route,
                    $vuetify.lang.t('$vuetify.word.domain.domain')
                )
            }
        },
    },
    {
        path: 'dns/:name',
        name: 'company.system.dns',
        component: () => import('../../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    vuexNamespace: 'company/system/dns/overview',
                    route: ({route}) => {
                        return $api.systemRoute('system.dns.search', route.params.name)
                    },
                    updateOnRouteChange: (to, from) => {
                        return to.params.name !== from.params.name
                    }
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
                app.$breadcrumbs.setCompanySystem(
                    route,
                    $vuetify.lang.t('$vuetify.word.dns.dns')
                )
            }
        },
    },
    {
        path: 'db/:name',
        name: 'company.system.database',
        component: () => import('../../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    vuexNamespace: 'company/system/database/overview',
                    route: ({route}) => {
                        return $api.systemRoute('system.database.search', route.params.name)
                    },
                    updateOnRouteChange: (to, from) => {
                        return to.params.name !== from.params.name
                    }
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
                app.$breadcrumbs.setCompanySystem(
                    route,
                    $vuetify.lang.t('$vuetify.word.database.database')
                )
            }
        },
    },
    {
        path: 'm/:name',
        name: 'company.system.mail',
        component: () => import('../../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    vuexNamespace: 'company/system/mailDomain/overview',
                    route: ({route}) => {
                        return $api.systemRoute('system.mail.domain.search', route.params.name)
                    },
                    updateOnRouteChange: (to, from) => {
                        return to.params.name !== from.params.name
                    }
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
                app.$breadcrumbs.setCompanySystem(
                    route,
                    $vuetify.lang.t('$vuetify.word.mail.domain')
                )
            }
        },
    },
]
