export default {
    /**
     * @description token在Cookie中存储的天数，默认1天
     */
    cookieExpires: 1,

    /**
     * @description api请求基础路径
     */
    baseUrl: {
        pro: 'api/'
    },
    Ueconfig: {
        serverUrl: '/static/UEditor/php/controller.php'
    },
}

// 引入JSON工具类
import JsonHandler from '../utils/jsonHandler'
import basedata from './basedata.json'

/**
 * 暴露其他配置信息
 */
export const BaseData = new JsonHandler(basedata);