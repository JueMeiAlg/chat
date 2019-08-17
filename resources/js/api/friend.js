import axios from "@/libs/axios";

/**
 * 好友分栏信息
 *
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const columnFriend = () => {
    return axios.request({
        url: 'user/column',
        method: 'get'
    })
};

/**
 * 新增好友分栏
 *
 * @param data
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const storeColumn = (data) => {
    return axios.request({
        url: 'user/column',
        data,
        method: 'post'
    })
};

/**
 * 修改好友分栏信息
 *
 * @param id
 * @param data
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const updateColumn = (id, data) => {
    return axios.request({
        url: 'user/column/' + id,
        data,
        method: 'put'
    })
};

/**
 * 删除分栏信息
 *
 * @param id
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const destroyColumn = (id) => {
    return axios.request({
        url: 'user/column/' + id,
        method: 'delete'
    })
};

/**
 * 删除好友
 *
 * @param id
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>>}
 */
export const destroyFriend = (id) => {
    return axios.request({
        url: 'user/friend/' + id,
        method: 'delete'
    })
};

/**
 *
 * 搜索好友
 *
 * @param data
 * @param page
 * @param limit
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const searchFriend = (data, page = 1, limit = 10) => {
    return axios.request({
        url: 'user/friend/search?page=' + page + '&limit=' + limit,
        data,
        method: 'post'
    })
};
/**
 * 添加好友
 *
 * @param data
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const storeFriend = (data) => {
    return axios.request({
        url: 'user/friend',
        data,
        method: 'post'
    })
};

/**
 * 好友认证消息
 *
 * @param data
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const storeFriendAuth = (data) => {
    return axios.request({
        url: 'user/friend/auth',
        data,
        method: 'post'
    })
};

/**
 * 好友添加消息
 *
 * @param page
 * @param limit
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const friendAuth = (page, limit) => {
    return axios.request({
        url: 'user/friend/auth?page=' + page + '&limit=' + limit,
        method: 'get'
    })
};
/**
 * 消息未读数量
 *
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const friendAuthCount = () => {
    return axios.request({
        url: 'user/friend/auth/count',
        method: 'get'
    })
};
