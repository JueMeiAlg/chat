export default [
    {
        path: '/', name: 'home', component: resolve => require(['@/view/home'], resolve),
    },
    {
        path: '/login', name: 'login', component: resolve => require(['@/view/login'], resolve)
    },
];