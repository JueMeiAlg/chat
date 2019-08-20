import axios from "@/libs/axios";
//import {getToken} from "@/libs/util";

export const login = (data) => {
    return axios.request({
        url: 'login?type=normal',
        data,
        method: 'post'
    })
};

export const logout = (token) => {
    return axios.request({
        url: 'logout?token' + token,
        method: 'get'
    })
};

/**
 * 查看用户信息
 *
 * @param id
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>>}
 */
export const userInfo = (id) => {
    return axios.request({
        url: 'user/' + id + '/info',
        method: 'get',
    })
};

/**
 * 根据Fd获取用户信息
 *
 * @param fd
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const fdUserInfo = (fd) => {
    return axios.request({
        url: 'user/' + fd + '/fd/info',
        method: 'get',
    })
};






