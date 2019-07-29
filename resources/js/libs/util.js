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