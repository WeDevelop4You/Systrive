import Import from "../../helpers/Import";

const app = Import.app()
const $api = Import.api()

export default [
    {
        path: '/',
        name: 'company.cms.table',
        component: () => import('../../components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({store, route}) => {
                        return $api.companyRoute(
                            'company.cms.table.search',
                            store.getters['company/cms/id'],
                            route.params.tableName
                        )
                    },
                    updateOnRouteChange: (to, from) => {
                        const isSameCms = to.params.cmsName === from.params.cmsName
                        const isNotSameTable = to.params.tableName !== from.params.tableName

                        return isSameCms && isNotSameTable
                    }
                }
            }
        },
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
                app.$breadcrumbs.setCompanyCms(route)
            }
        },
    }
]
