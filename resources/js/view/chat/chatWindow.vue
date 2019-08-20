<template>
    <div class="chat-window" v-if="$store.state.talk.friendList.length > 0">
        <el-row>
            <el-col :span="6">
                <div class="chat-list">
                    <el-row @click.native="setBeingChatFriend(friend)" class="chat-friend-item"
                            v-for="(friend, index) in $store.state.talk.friendList"
                            :key="index">
                        <el-col :span="8">
                            <el-avatar :class="friend.fd? '' : 'friend-list-off-line'" :size="50"
                                       :src="friend.avatar"></el-avatar>
                        </el-col>
                        <el-col :span="12" class="user-name-main">
                            <span>{{friend.name}}</span>
                        </el-col>
                        <el-col :span="2">
                            <div class="close-friend-chat" @click="removeFriendChat(index)">
                                <svg class="icon" aria-hidden="true">
                                    <use xlink:href="#icon-cha1"></use>
                                </svg>
                            </div>
                        </el-col>
                    </el-row>
                </div>
            </el-col>
            <el-col :span="18">
                <el-row>
                    <el-col :span="24">
                        <el-row class="userInfo">
                            <el-col :span="3">
                                <el-avatar
                                        :class="$store.state.talk.currentBeinTalkFriend.fd? '' : 'friend-list-off-line'"
                                        :size="50" :src="$store.state.talk.currentBeinTalkFriend.avatar"></el-avatar>
                            </el-col>
                            <el-col :span="19">
                                <div class="userStatus">
                                    <p class="username">{{$store.state.talk.currentBeinTalkFriend.name}}</p>
                                    <p class="status" v-if="$store.state.talk.currentBeinTalkFriend.fd == null">离线</p>
                                    <p class="status" v-else>在线</p>
                                </div>
                            </el-col>
                            <el-col :span="2">
                                <i title="关闭全部聊天窗口" @click="narrowBeingChatWindow" class="el-icon-minus minus"></i>
                                <i title="关闭当前聊天窗口" @click="closeBeingChatWindow" class="el-icon-close close"></i>
                            </el-col>
                        </el-row>
                    </el-col>
                    <el-col :span="24">
                        <div class="talk">
                            <template v-for="chat in $store.state.talk.currentBeingTalkRecord">
                                <template v-if="chat.user_id != $store.state.user.userId">
                                    <div class="friendTalk-main">
                                        <div class="friendTalk">
                                            {{chat.msg}}
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="myTalk-main">
                                        <div class="myTalk">
                                            {{chat.msg}}
                                        </div>
                                    </div>
                                </template>
                            </template>

                        </div>
                    </el-col>
                    <el-col :span="24">
                        <div class="tool">
                            聊天工具条
                        </div>
                    </el-col>
                    <el-col :span="24">
                        <el-row class="message-main">
                            <el-col :span="24">
                                <div class="message">
                                    <el-input  :autosize="{ minRows: 4, maxRows: 4}" v-model="msg" :rows="4" type="textarea" style="height:100px;"></el-input>
                                </div>
                            </el-col>
                            <el-col :offset="16" :span="2">
                                <el-button size="small" class="close-button">关闭</el-button>
                            </el-col>
                            <el-col :offset="1" :span="2">
                                <el-button size="small" class="send-button">发送</el-button>
                            </el-col>
                        </el-row>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        name: "chatWindow",
        data() {
            return {
                msg: '',
            }
        },
        created() {

        },
        methods: {
            removeFriendChat(index) {
                if (this.$store.state.talk.currentBeinTalkFriend.id == this.$store.state.talk.friendList[index].id) {
                    this.msg = "";
                }
                this.$store.state.talk.friendList.splice(index, 1);
            },
            /**
             * 关闭正在交谈的好友对话框
             */
            closeBeingChatWindow() {
                this.$store.state.talk.friendList.forEach((item, index) => {
                    if (item.id == this.$store.state.talk.currentBeinTalkFriend.id) {
                        this.removeFriendChat(index);
                        return;
                    }
                });
                //列表第一个置为交谈对象
                this.setBeingChatFriend(this.$store.state.talk.friendList[0]);
            },

            narrowBeingChatWindow() {
                this.$store.state.talk.friendList = [];
                this.msg = "";
            },
            setBeingChatFriend(friend) {
                this.msg = "";
                this.$store.commit('setCurrentBeinTalkFriend', friend);
            }
        }
    }
</script>

<style scoped>
    .chat-window {
        height: 600px;
        margin-right: 50px;
    }

    .chat-list {
        background: #d9d9d9;
        height: 580px !important;
        padding: 10px;
    }

    .user-name-main {
        padding-top: 15px;
        color: #404040;
    }

    .userInfo {
        background: #ececec;
        padding: 10px;
    }

    .userStatus {
        padding-top: 5px;
    }

    .username {
        font-size: 18px;
    }
    .status {
        font-size: 14px;
        color: #a6a6a6;
    }

    .minus {
        margin-right: 5px
    }

    .close {

    }

    .talk {
        height: 340px;
        background: #fbfbfb;
        overflow-x: hidden;
        overflow-y: scroll;
    }

    .talk::-webkit-scrollbar {
        display: none;
    }

    .tool {
        padding-top: 4px;
        height: 40px;
        background: #fbfbfb;
    }

    .message-main {
        background: #fbfbfb;
    }

    .message {
        height: 100px;
    }

    .chat-friend-item:hover {
        background: #f5f5f5;
    }

    .send-button {
        background: #5fb878;
        color: #ecf7f0;
        width: 100px;
        margin-bottom: 10px;
    }

    .close-button {
        background: #5fb878;
        color: #ecf7f0;
        margin-bottom: 10px;
    }

    .nameTime {
        margin-bottom: 5px;
    }

    .friendTalk-main {
        padding: 5px 5px 5px 20px;
        text-align: left;
        width: 100%;
    }

    .friendTalk {
        padding: 5px;
        background: #e2e2e2;
        width: 50%;
        float: left;
    }

    .myTalk-main {
        float: right;
        padding: 5px 20px 5px 5px;
        text-align: left;
        width: 100%
    }

    .myTalk {
        background: #5fb878;
        padding: 5px;
        color: #fff;
        width: 50%;
        float: right;
    }

    .close-friend-chat {
        display: none;
        font-size: 12px;
    }

    .close-friend-chat:hover {
        background: #d5d5d5;
    }

    .chat-friend-item:hover .close-friend-chat {
        display: block;
    }

    .friend-list-off-line {
        filter: grayscale(1);
        opacity: 0.8;
    }
</style>