import Import from "../../helpers/Import";

//routes
import cms from "./cms";
import admin from "./admin";
import system from "./system";

const app = Import.app()
const parent = {template: `<router-view></router-view>`}

export default [
    {
        path: 'dashboard',
        name: 'company.dashboard',
        component: () => import('../../components/Overviews/Page.vue'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
                app.$breadcrumbs.setCompany(route)
            }
        },
    },
    {
        path: 'cms/:cmsName/table/:tableName',
        component: () => import('../../views/Company/Cms.vue'),
        children: cms
    },
    {
        path: 'system',
        component: parent,
        children: system
    },
    {
        path: 'admin',
        component: parent,
        children: admin
    },
]
