import Vue from 'vue'
import Vuex from 'vuex'

import user from './module/user'
import friendPanelTool from './module/friendPanelTool'
import talk from './module/talk'
import friend from './module/friend'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        //状态
    },
    mutations: {
        //更改
    },
    actions: {
        //动作
    },
    modules: {
        user,
        friendPanelTool,
        talk,
        friend
    }
})