export default [
    {
        path: '/',
        name: 'cms.table',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    route: ({app, route}) => app.$api.companyRoute(
                        'company.cms.table.search',
                        app.$store.getters['cms/id'],
                        route.params.tableName
                    ),
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
            breadcrumbs: ({app, route}) => app.$breadcrumbs.setCms(route)
        },
    }
]
