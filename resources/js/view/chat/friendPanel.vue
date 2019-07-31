<template>
    <div class="Panel-main">
        <el-row>
            <el-col :span="24">
                <el-row>
                    <el-col :span="12">用户名</el-col>
                    <el-col :span="12">登录状态</el-col>
                </el-row>
            </el-col>
            <el-col :span="24">
                个性签名
            </el-col>
            <el-col :span="8">好友</el-col>
            <el-col :span="8">群聊</el-col>
            <el-col :span="8">消息记录</el-col>
            <el-col :span="24">好友或者群聊或消息记录列表</el-col>
            <el-col :span="24">系统设置</el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        name: "friendPanel"
    }
</script>

<style scoped>
    .Panel-main {
        height: 600px;
        background: #2fa360;
    }
</style>