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

export const userInfo = () => {
    return axios.request({
        url: 'userInfo',
        method: 'get',
    })
};

export const addUser = (data) => {
    return axios.request({
        url: 'user',
        data,
        method: 'post',
    })
};
export const editUser = (data, id) => {
    return axios.request({
        url: 'user/' + id,
        data,
        method: 'put',
    })
};





