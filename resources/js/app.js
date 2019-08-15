
require('@/bootstrap');
window.Vue = require('vue');

import router from './router';
import store from './store';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    router,
    store
});

window.vueApp = app;