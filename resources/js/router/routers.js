
export default [
    {
        path: '/', component:resolve=>require(['@/view/home'],resolve),
    },
    {
        path: '/login', name:'login',component:resolve=>require(['@/view/login'],resolve)
    },
];