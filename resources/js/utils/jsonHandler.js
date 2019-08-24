export default class JsonHandler {
    constructor(config) {
        this.config = config;
    }

    /**
     * 获取格式化后的JSON数据
     *
     * @param {*} keyword
     * @param {*} key
     * @param {*} value
     */
    get(main, key) {
        return this.config[main][key];
    }
}