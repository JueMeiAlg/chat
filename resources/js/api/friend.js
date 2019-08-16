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
