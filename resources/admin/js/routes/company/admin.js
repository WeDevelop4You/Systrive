import Import from "../../helpers/Import";
import Breadcrumb from "../../helpers/Breadcrumb";
import {STATE_EDIT, STATE_CREATE} from "../../config/RouteState";

const app = Import.app()
const $api = Import.api()
const $vuetify = Import.vuetify()

export default [
    {
        path: 'users/:chapters*',
        name: 'company.admin.users',
        component: () => import('../../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({store}) => {
                        store.dispatch('permissions/getList')
                        store.dispatch('company/roles/dropList')

                        return $api.companyRoute('company.user.overview')
                    }
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            allowedStates: [STATE_CREATE, STATE_EDIT],
            breadcrumbs(route) {
                app.$breadcrumbs.setCompanyAdmin(route)
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.users')))
            }
        },
    },
    {
        path: 'roles/:chapters*',
        name: 'company.admin.roles',
        component: () => import('../../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: () => {
                        return $api.companyRoute('company.role.overview')
                    }
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            allowedStates: [STATE_CREATE, STATE_EDIT],
            breadcrumbs(route) {
                app.$breadcrumbs.setCompanyAdmin(route)
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.roles')))
            }
        },
    }
]
