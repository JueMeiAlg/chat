import Cookies from 'js-cookie'
import config from '@/config'

export const TOKEN_KEY = 'token';

/**
 * 设置登录标识
 *
 * @param token
 */
export const setToken = (token) => {
    Cookies.set(TOKEN_KEY, token, {expires: config.cookieExpires || 1})
};

/**
 * 获得登录标识
 *
 * @returns {boolean|*}
 */
export const getToken = () => {
    const token = Cookies.get(TOKEN_KEY);
    if (token) {
        return token;
    } else {
        return false
    }
};


/**
 * 设置当前登录用户Id到cookie
 *
 * @param userId
 */
export const setUserId = (userId) => {
    Cookies.set('userId', userId, {expires: config.cookieExpires || 1})
};

/**
 * 获得当前登录的用户Id
 *
 * @returns {boolean|*}
 */
export const getUserId = () => {
    const userId = Cookies.get('userId');
    if (userId) {
        return userId;
    } else {
        return false
    }
};