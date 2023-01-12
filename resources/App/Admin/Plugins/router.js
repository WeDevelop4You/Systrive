import Vue from "vue";
import Routes from "../Routes";
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: Routes
})

// router.beforeEach(async (to, from, next) => {
//     app.$activity.lastRoute = from.name ? from : to
//
//     if (to.meta.isAuthenticatedPage) {
//         const page = to.meta.page
//
//         if (!app.$auth.isLoaded()) {
//             app.$auth.load();
//         }
//
//         if ((!page && !from.name) || page !== from.meta.page) {
//             switch (page) {
//                 case 'company':
//                     await $store.dispatch('company/search', to.params.companyName)
//                     await $store.dispatch('user/auth/permissions/getCompany')
//                     break
//                 default:
//                     await $store.dispatch('navigation/main')
//                     await $store.dispatch('user/auth/permissions/getDefault')
//                     break
//             }
//         }
//     }
//
//     next()
// })
//

export default router
