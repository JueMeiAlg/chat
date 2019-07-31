<template>
    <div class="chat-window">
       <el-row>
           <el-col :span="6">
               <div>头像</div>
               <div>用户名</div>
           </el-col>
           <el-col :span="18">
               <el-row>
                   <el-col :span="20">
                       <div>头像</div>
                       <div>
                           <p>用户名</p>
                           <p>登录状态</p>
                       </div>
                   </el-col>
                   <el-col :span="2">
                       <span>缩小</span>
                       <span>关闭</span>
                   </el-col>
                   <el-col :span="24">
                       聊天主窗口
                   </el-col>
                   <el-col :span="24">
                       聊天工具条
                   </el-col>
                   <el-col :span="24">
                       消息编辑器
                   </el-col>
                   <el-col>
                       <el-button>发送</el-button>
                       <el-button>关闭</el-button>
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
        background: #ffed4a;
        margin-right: 50px;
    }
</style>