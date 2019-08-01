<template>
    <div class="chat-window">
       <el-row>
           <el-col :span="6">
               <div class="chat-list">
                   <el-row>
                       <el-col :span="8">
                           <el-avatar :size="50" :src="'https://lorempixel.com/200/200/cats/?74058'">
                           </el-avatar>
                       </el-col>
                       <el-col :span="12" class="user-name-main">
                           <span>用户名</span>
                       </el-col>
                   </el-row>
               </div>
           </el-col>
           <el-col :span="18">
               <el-row>
                   <el-col :span="24">
                       <el-row class="userInfo">
                           <el-col :span="3">
                               <el-avatar :size="50" :src="'https://lorempixel.com/200/200/cats/?74058'">
                               </el-avatar>
                           </el-col>
                           <el-col :span="19">
                               <div class="userStatus">
                                   <p class="username">用户名</p>
                                   <p class="status">离线</p>
                               </div>
                           </el-col>
                           <el-col :span="2">
                               <i class="el-icon-minus minus"></i>
                               <i class="el-icon-close close"></i>
                           </el-col>
                       </el-row>
                   </el-col>
                   <el-col :span="24">
                       <div class="talk">

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
                                   消息编辑器
                               </div>
                           </el-col>
                           <el-col :offset="16" :span="2">
                               <el-button size="small" class="close-button">关闭</el-button>
                           </el-col>
                           <el-col :offset="1"  :span="2">
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
        name: "chatWindow"
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
    .userStatus{
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
    .close{

    }
    .talk {
        height: 340px;
        background: #fbfbfb;
    }
    .tool {
        height: 44px;
        background: #fbfbfb;
    }
    .message-main {
        background: #fbfbfb;
    }
    .message {
        height: 100px;
    }
    .send-button{
        background: #5fb878;
        color:#ecf7f0;
        width: 100px;
        margin-bottom: 10px;
    }
    .close-button{
        background: #5fb878;
        color:#ecf7f0;
        margin-bottom: 10px;
    }
</style>