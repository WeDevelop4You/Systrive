import Breadcrumb from "../../../Support/Helpers/Breadcrumb";
import {STATE_EDIT, STATE_CREATE} from "../../../Support/Config/RouteState";

export default [
    {
        path: 'users/:chapters*',
        name: 'admin.users',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({app}) => app.$api.companyRoute('company.user.overview')
                }
            }
        },
        meta: {
            page: 'company',
            allowedStates: [STATE_CREATE, STATE_EDIT],
            breadcrumbs: ({app, vuetify, route}) => app.$breadcrumbs.setAdmin(route)
                .add(new Breadcrumb(vuetify.lang.t('$vuetify.word.users')))
        },
    },
    {
        path: 'roles/:chapters*',
        name: 'admin.roles',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({app}) => app.$api.companyRoute('company.role.overview')
                }
            }
        },
        meta: {
            page: 'company',

            allowedStates: [STATE_CREATE, STATE_EDIT],
            breadcrumbs: ({app, vuetify, route}) => app.$breadcrumbs.setAdmin(route)
                .add(new Breadcrumb(vuetify.lang.t('$vuetify.word.roles')))
        },
    }
]
