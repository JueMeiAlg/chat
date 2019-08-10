<template>
    <div class="Panel-main">
        <div>
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
                            <li class="column" v-for="(item, index) in friend" style="overflow: hidden">
                                <span @click="openList(index)">
                                    <svg class="icon corners" aria-hidden="true">
                                        <use :id="'sj'+index" xlink:href="#icon-yousanjiaoxing"></use>
                                    </svg>
                                </span>
                                {{item.column}}
                                <ul :id="'friendColumn'+index" class="list" style="display: none;">
                                    <li v-for="(friendItem, index) in item.userInfo">
                                        <div class="userInfo">
                                            <el-avatar class="fl" :size="50" :src="friendItem.avatar"></el-avatar>
                                            <div class="fl" style="margin-left: 10px;">
                                                <div class="username">{{friendItem.username}}</div>
                                                <div class="userSignature">{{friendItem.signature}}</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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
                friend: [
                    {
                        column: "我的好友(40/80)",
                        userInfo: [
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "我的好友1",
                                signature: "我的好友1个性签名",
                            },
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "我的好友2",
                                signature: "我的好友2个性签名",
                            }
                        ]
                    },
                    {
                        column: "编程达人(25/42)",
                        userInfo: [
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "编程达人1",
                                signature: "编程达人1个性签名",
                            },
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "编程达人2",
                                signature: "编程达人2个性签名",
                            },
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "编程达人2",
                                signature: "编程达人2个性签名",
                            },
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "编程达人2",
                                signature: "编程达人2个性签名",
                            },
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "编程达人2",
                                signature: "编程达人2个性签名",
                            },
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "编程达人2",
                                signature: "编程达人2个性签名",
                            },
                            {
                                avatar: "https://lorempixel.com/200/200/cats/?74058",
                                username: "编程达人2",
                                signature: "编程达人2个性签名",
                            },
                        ]
                    }
                ]
            }
        },
        methods: {
            console(praented) {
                console.log(praented)
            },
            /**
             * 打开好友列表
             */
            openList(index) {
                if (window.document.getElementById('sj' + index).getAttribute('xlink:href') === "#icon-sanjiao") {
                    window.document.getElementById('friendColumn' + index).style.display = "none";
                    window.document.getElementById('sj' + index).setAttribute('xlink:href', '#icon-yousanjiaoxing');
                } else {
                    window.document.getElementById('sj' + index).setAttribute('xlink:href', '#icon-sanjiao');
                    window.document.getElementById('friendColumn' + index).style.display = "";
                }
            }
        }
    }
</script>

<style scoped>
    .Panel-main {
        height: 600px;
        background: #f9f9f9;
    }

    .head {
        background: #d6d6d6;
        height: 100px;
        padding: 15px;
    }

    .Signature {
        margin-top: 10px;
        margin-bottom: 25px;
    }

    .friendIcon {
        font-size: 25px;
    }

    .friendList {
        background: #f9f9f9;
        height: 400px;
        padding: 15px;
        /*overflow: hidden;*/
        overflow-x: hidden;
        overflow-y: scroll;
    }

    .friendList::-webkit-scrollbar {
        display: none;
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

    .userSignature {
        color: #b7b7b7;
    }

    .username {
        font-size: 18px;
    }

    .column {
        margin-bottom: 15px;
    }

    .corners {
        color: #6fa7d6;
    }

    .list {
        margin-top: 15px;
        padding-left: 10px;
    }

    .userInfo {
        clear: both;
        height: 55px;
        padding: 5px;
    }
    .userInfo:hover{
        /*border: 1px solid #1b1e21;*/
        background: #f2f2f2;
    }

</style>