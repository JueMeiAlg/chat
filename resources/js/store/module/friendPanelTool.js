import { friendAuthCount } from '@/api/friend'

export default {
    state: {
        systemNotifyNum: '',
        friendNotifyNum: '',
        shareNotifyNum: '',
    },
    mutations: {
        setSystemNotifyNum(state, systemNotifyNum) {
            state.systemNotifyNum = systemNotifyNum
        },
        setFriendNotifyNum (state, friendNotifyNum) {
            state.friendNotifyNum = friendNotifyNum
        },
        setShareNotifyNum (state, shareNotifyNum) {
            state.shareNotifyNum = shareNotifyNum
        },
    },
    actions: {
        // 好友信息未读数量
        friendAuthNum ({ commit }) {
            return new Promise((resolve, reject) => {
                friendAuthCount().then(res => {
                    const data = res.data;
                    if (data.code === 0){
                        commit('setFriendNotifyNum', data.data.count);
                        resolve(data)
                    }else{
                        reject('code is not 0')
                    }
                }).catch(err => {
                    reject(err)
                })
            })
        },
    }
}