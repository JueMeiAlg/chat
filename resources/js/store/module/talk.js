import {chatMsgRecord} from '@/api/chat';

export default {
    state: {
        //交谈中的好友列表
        friendList: [],
        //当前交谈的用户
        currentBeinTalkFriend: {
            avatar:"",
            fd:"",
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
            state.currentBeingTalkRecord = [];
            chatMsgRecord(friend.id).then((response) => {
                response.data.data.forEach(item => {
                    state.currentBeingTalkRecord.push(item);
                    state.friendChatRecord.push({friend_id: item.friend_id, record: item})
                });
            });
            state.currentBeinTalkFriend = friend;
        }
    },
    actions: {}
}