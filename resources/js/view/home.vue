<template>
    <div class="main">
        <div class="chat-main">
            <el-row>
                <el-col :span="18">
                    <chat></chat>
                </el-col>
                <el-col :span="6">
                    <panel></panel>
                </el-col>
            </el-row>
        </div>
    </div>
</template>

<script>
    import panel from './chat/friendPanel';
    import chat from './chat/chatWindow';

    export default {
        name: "home",
        components: {panel, chat},
    }
</script>

<style scoped>
    .main {
        background: #17443e;
        height: 100%;
        width: 100%;
    }

    .chat-main {
        width: 85%;
        margin: 0 auto;
        padding: 50px;
    }
</style>