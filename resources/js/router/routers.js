export default [
    {
        path: '/', name: 'login', component: resolve => require(['@/view/login'], resolve),
    },
    {
        path: '/home', name: 'home', component: resolve => require(['@/view/home'], resolve)
    },
];