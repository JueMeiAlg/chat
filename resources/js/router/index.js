import VueRouter from 'vue-router'
import routes from './routers'
import Vue from 'vue'
import {getToken, setToken} from '@/libs/util'

Vue.use(VueRouter);
const router = new VueRouter({
    routes,
    mode: 'hash'
});

const HOME_PAGE_NAME = 'home';
const LOGIN_PAGE_NAME = 'login';
const REGISTER_PAGE_NAME = 'register';

router.beforeEach((to, from, next) => {
    let is_login = true
    let token = getToken();

    if (token == 'undefined' || getToken() == 'null') {
        is_login = false;
    }

    if (!is_login && to.name !== LOGIN_PAGE_NAME && to.name !== REGISTER_PAGE_NAME) {
        // 未登录且要跳转的页面不是登录页和注册页
        next({
            name: LOGIN_PAGE_NAME
        })
    } else if (!is_login && (to.name === LOGIN_PAGE_NAME || to.name === REGISTER_PAGE_NAME)) {
        // 未登陆且要跳转的页面是登录页或注册页
        next() // 跳转
    } else if (is_login && to.name === LOGIN_PAGE_NAME) {
        // 已登录且要跳转的页面是登录页
        next({
            name: HOME_PAGE_NAME
        })
    } else {
        next()
    }
});
export default router