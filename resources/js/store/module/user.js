import { login, userInfo } from '@/api/user'
import { setToken,getToken, setUserId} from '@/libs/util';

export default {
    state: {
        token:getToken(),
        userName: '',
        signature: '',
        userId: '',
        avatar: '',
    },
    mutations: {
        setAvatar (state, avatar) {
            state.avatar = avatar
        },
        setUserId (state, id) {
            state.userId = id
        },
        setUserName (state, name) {
            state.userName = name
        },
        setToken(state, token) {
            state.token = token
        },
        setSignature(state, signature) {
            state.signature = signature
        },
    },
    actions: {
        // 登录
        handleLogin ({ commit }, from) {
            return new Promise((resolve, reject) => {
                login(from).then(res => {
                    const data = res.data;
                    if (data.code === 0){
                        commit('setToken', data.data.token);
                        commit('setUserName', data.data.user.name);
                        commit('setSignature', data.data.user.signature);
                        commit('setUserId', data.data.user.id);
                        commit('setAvatar', data.data.user.avatar);
                        setToken(data.data.token);
                        setUserId(data.data.user.id);
                        resolve(data)
                    }else{
                        reject('code is not 0')
                    }
                }).catch(err => {
                    reject(err)
                })
            })
        },
        // 退出登录
        handleLogOut ({ state, commit }) {
            return new Promise((resolve) => {
                commit('setToken', null);
                commit('setUserName', '');
                commit('setSignature', '');
                commit('setUserId', '');
                commit('setAvatar', '');
                setToken();
                setUserId();
                resolve()
            })
        },
    }
}