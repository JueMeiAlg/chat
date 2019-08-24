
require('@/bootstrap');
window.Vue = require('vue');

import router from './router';
import store from './store';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import Cookies from "js-cookie";

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    router,
    store
});

//全局监听，页面刷新的时候将store里state的值存到sessionStorage中，然后从sessionStorage中获取，
// 再赋值给store。然后再把session里面存的删除即可，相当于中间件的作用。
//在页面加载时读取sessionStorage里的状态信息
// if (sessionStorage.getItem("store")) {
//     app.$store.replaceState(
//         Object.assign(
//             {},
//             app.$store.state,
//             JSON.parse(sessionStorage.getItem("store"))
//         )
//     );
//     sessionStorage.removeItem("store")
// }
//
// //在页面刷新时将vuex里的信息保存到sessionStorage里
// window.addEventListener("beforeunload", () => {
//     sessionStorage.setItem("store", JSON.stringify(app.$store.state));
// });

//页面刷新时候清空所有记录,让他重新登录
window.addEventListener("beforeunload", () => {
    Cookies.remove('fd');
    Cookies.remove('userId');
    Cookies.remove('token');
});

window.vueApp = app;