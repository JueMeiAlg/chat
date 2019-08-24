export default [
    {
        path: '/', name: 'login', component: resolve => require(['@/view/login'], resolve),
    },
    {
        path: '/register', name: 'register', component: resolve => require(['@/view/register'], resolve),
    },
    {
        path: '/home', name: 'home', component: resolve => require(['@/view/home'], resolve)
    },
];