import cms from "./cms";
import admin from "./admin";
import system from "./system";

const $parent = {template: `<router-view></router-view>`}

export default [
    {
        path: '/switcher',
        component: () => import('../../../Support/Layout/MinimalLayout.vue'),
        children: [
            {
                path: '/switcher',
                name: 'switcher',
                component: () => import('../../../Support/Components/Overviews/Page.vue'),
                props: {
                    value: {
                        data: {
                            vuexNamespace: 'switcher',
                            route: ({app}) => app.$api.route('company.switcher.overview'),
                        }
                    }
                }
            },
            {
                path: '*',
                redirect: {name: 'switcher'},
            }
        ]
    }, {
        path: '/:companyName',
        component: () => import('../../../Support/Layout/MainLayout.vue'),
        props: {
            load: (app) => app.$store.dispatch('initialize', app.$route.params.companyName)
        },
        children: [
            {
                path: '/:companyName',
                name: 'dashboard',
                component: () => import('../../../Support/components/Overviews/Page.vue'),
                meta: {
                    page: 'company',
                    breadcrumbs: ({app, route}) => {
                        app.$breadcrumbs.setDashboard(route)
                    }
                },
            }, {
                path: 'cms/:cmsName/table/:tableName',
                component: () => import('../Views/Cms.vue'),
                children: cms
            }, {
                path: 'system',
                component: $parent,
                children: system
            }, {
                path: 'admin',
                component: $parent,
                children: admin
            }, {
                path: '*',
                redirect: (to) => {
                    return {name: 'dashboard', params: {companyName: to.params.companyName}}
                }
            }
        ]
    }, {
        path: '*',
        redirect: {name: 'switcher'}
    }
]
