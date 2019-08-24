import {chatMsgRecord} from '@/api/chat'
import wsk from '@/libs/wsk';

export default {
    state: {
        //交谈中的好友列表
        friendList: [],
        //当前交谈的用户
        currentBeinTalkFriend: {
            avatar: "",
            fd: "",
        },
        //当前交谈用户的聊天记录
        currentBeingTalkRecord: [],

        //好友聊天记录
        friendChatRecord: []
    },
    mutations: {

        setFriendList(state, friend) {
            let isPush = true;
            state.friendList.forEach(item => {
                if (item.id == friend.id) {
                    isPush = false;
                }
            });
            if (isPush) {
                state.friendList.unshift(friend)
            }
            this.commit('setCurrentBeinTalkFriend', friend);
        },

        setCurrentBeinTalkFriend(state, friend) {
            if (wsk.isExistMsgRecord(friend.id) === false) {
                wsk.getFriendMsgRecord(friend.id);
            }
            state.currentBeinTalkFriend = friend;

            let cache = [];
            state.currentBeingTalkRecord = [];
            for (let i = 0; i < window.vueApp.$store.state.talk.friendChatRecord.length; i++) {
                if (window.vueApp.$store.state.talk.friendChatRecord[i].id == friend.id) {
                    cache = window.vueApp.$store.state.talk.friendChatRecord[i].record;
                    cache.forEach(item => {
                        state.currentBeingTalkRecord.push(item);
                    });
                    return;
                }
            }

            chatMsgRecord(friend.id).then((apiRes) => {
                window.vueApp.$store.state.talk.friendChatRecord.push({
                    id: friend.id,
                    record: apiRes.data.data
                });
                let cache = [];
                for (let i = 0; i < window.vueApp.$store.state.talk.friendChatRecord.length; i++) {
                    if (window.vueApp.$store.state.talk.friendChatRecord[i].id == friend.id) {
                        cache = window.vueApp.$store.state.talk.friendChatRecord[i].record;
                        cache.forEach(item => {
                            state.currentBeingTalkRecord.push(item);
                        });
                        return;
                    }
                }
            });
        }
    },
    actions: {}
}