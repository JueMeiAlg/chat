<template>
    <div class="Panel-main">
        <div class="panelBox">
            <el-row>
                <div class="head">
                    <el-col :span="24">
                        <el-row>
                            <el-col :span="8">
                                Alg
                            </el-col>
                        </el-row>
                    </el-col>
                    <el-col :span="24">
                        <div class="Signature">个性签名</div>
                    </el-col>
                    <div class="friendButton">
                        <el-col :span="8">
                            <svg class="icon friendIcon" aria-hidden="true">
                                <use xlink:href="#icon-ren"></use>
                            </svg>
                        </el-col>
                        <el-col :span="8">
                            <svg class="icon friendIcon" aria-hidden="true">
                                <use xlink:href="#icon-users"></use>
                            </svg>
                        </el-col>
                        <el-col :span="8">
                            <svg class="icon friendIcon" aria-hidden="true">
                                <use xlink:href="#icon-xinxi"></use>
                            </svg>
                        </el-col>
                    </div>
                </div>
                <el-col :span="24">
                    <div class="friendList">
                        <ul>
                            <li class="column">
                                <svg class="icon corners" aria-hidden="true">
                                    <use xlink:href="#icon-yousanjiaoxing"></use>
                                </svg>
                                我的好友(40/80)
                            </li>
                            <li>
                                <div class="userInfo">
                                    <el-avatar class="fl" :size="50" :src="'https://lorempixel.com/200/200/cats/?74058'"></el-avatar>
                                    <div class="fl" style="margin-left: 10px;">
                                        <div class="username">用户名</div>
                                        <div class="userSignature">用户个性签名</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </el-col>
                <el-col :span="24">系统设置</el-col>
            </el-row>
        </div>
    </div>
</template>

<script>
    export default {
        name: "friendPanel",
        data() {
            return {

            }
        },
        methods:{
            console(praented) {
                console.log(praented)
            }
        }
    }
</script>

<style scoped>
    .Panel-main {
        height: 600px;
        background: #d6d6d6;
    }

    .panelBox {
        padding: 15px;
    }

    .head {
        background: #d6d6d6;
        height: 120px;
    }

    .Signature {
        margin-top: 10px;
        margin-bottom: 25px;
    }

    .friendIcon {
        font-size: 25px;
    }

    .friendButton .el-col-8 {
        padding-bottom: 5px;
        text-align: center;
    }
    .friendList >>> .el-tree-node__content {
        height: auto !important;
        padding-left: 0 !important;
    }
    .friendButton .el-col-8:hover {
        border-bottom: 3px solid #6cdb9e;
    }
    .userSignature{
        color: #b7b7b7;
    }
    .username{
        font-size: 18px;
    }
    .column {
        margin-bottom: 15px;
    }
    .corners {
        color: #6fa7d6;
    }

</style>