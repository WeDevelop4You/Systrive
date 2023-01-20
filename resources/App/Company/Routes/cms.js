export default [
    {
        path: '/',
        name: 'cms.table',
        component: () => import('../../../Support/Components/Overviews/Page.vue'),
        props: {
            value: {
                data: {
                    vuexNamespace: 'cms/table/overview',
                    route: ({app, route}) => app.$api.companyRoute(
                        'company.cms.table.search',
                        app.$store.getters['cms/id'],
                        route.params.tableName
                    ),
                    updateOnRouteChange: (to, from) => {
                        const isCms = to.params.cmsName === from.params.cmsName
                        const isNotTable = to.params.tableName !== from.params.tableName

                        return isCms && isNotTable
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
