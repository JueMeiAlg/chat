import axios from 'axios'
import config from '@/config'
import {getToken} from "./util"
import {Message} from 'element-ui'

const baseUrl = config.baseUrl.pro;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// 在实例已创建后修改默认值
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.baseURL = baseUrl;


// 添加请求拦截器
axios.interceptors.request.use(function (config) {
    // 添加Authorization
    config.headers['Authorization'] = 'Bearer ' + getToken();
    return config;
}, function (error) {
    return Promise.reject(error);
});


// 添加响应拦截器
axios.interceptors.response.use(function (response) {
    if(response.data.code < 0){
         Message({
            showClose: true,
            message: response.data.msg,
            type: 'error'
        });
        return Promise.reject(response);
    }
    return response;
}, function (error) {
    let code = error.response.status;
    let list = {
        404: '请求地址不存在',
        401: '无请求权限',
        422: error.response.data, //参数校验不通过
        500: '服务器错误，请稍后再试',
    };
    if (code == 401) {
        window.Vue.$router.push('/login')
    }

    Message({
        showClose: true,
        message: list[code],
        type: 'error'
    });
    return Promise.reject(error);
});

export default axios