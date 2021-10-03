import VueRouter from 'vue-router';

//pages
import Dashboard from '../js/components/main/Dashboard'
import Team from './components/main/team/Team'
import Work from './components/main/work/Work'
import Contact from './components/main/Contact'

//routes
const routes = [
    {
        path: '/',
        name: 'Dashboard',
        component: Dashboard
    },
    {
        path: '/Team',
        name: 'Team',
        component: Team
    },
    {
        path: '/Work',
        name: 'Work',
        component: Work
    },
    {
        path: '/Contact',
        name: 'Contact',
        component: Contact
    },
];

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});

export default router
