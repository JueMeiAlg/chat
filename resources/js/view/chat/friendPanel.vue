<template>
    <div class="Panel-main">
        <div>
            <el-row>
                <div class="head">
                    <el-col :span="24">
                        <el-row>
                            <el-col :span="8">
                                {{$store.state.user.userName}}
                            </el-col>
                        </el-row>
                    </el-col>
                    <el-col :span="24">
                        <div class="Signature">
                            {{$store.state.user.signature}}
                        </div>
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
                    <div class="friendList" @contextmenu.prevent="openSystemMenu">
                        <div class="contextMenu" id="systemMenu" style="display: none;">
                            <div class="contextMenu-item" @click="addColumnBoxOpen">
                                添加新分栏
                            </div>
                            <div class="contextMenu-item" @click="feedBack">
                                系统反馈
                            </div>
                            <div class="contextMenu-item">
                                <a href="https://github.com/JueMeiAlg/chat" target="_blank">gitHub点个星</a>
                            </div>
                        </div>
                        <div class="contextMenu" id="columnMenu" style="display: none;">
                            <div class="contextMenu-item" @click="destroyColumnInfo">
                                删除分栏
                            </div>
                            <div class="contextMenu-item" @click="editColumn">
                                重命名
                            </div>
                            <div class="contextMenu-item" @click="openColumn">
                                展开或收起
                            </div>
                        </div>
                        <div class="contextMenu" id="userMenu" style="display: none;">
                            <div class="contextMenu-item" @click="sendMsg">
                                发送消息
                            </div>
                            <div class="contextMenu-item" @click="deleteFriend">
                                删除好友
                            </div>
                            <div class="contextMenu-item" @click="showUserInfo">
                                查看信息
                            </div>
                        </div>
                        <ul>
                            <li class="column columnHover" v-for="(item, index) in $store.state.friend.columnFriend"
                                @contextmenu.prevent="openColumnMenu($event, item.id, item, index)">
                                <span @click="openList(index)">
                                    <svg class="icon corners" aria-hidden="true">
                                        <use :id="'sj'+index" xlink:href="#icon-yousanjiaoxing"></use>
                                    </svg>
                                </span>
                                {{item.name}}
                                <ul :id="'friendColumn'+index" class="list" style="display: none;">
                                    <li v-for="(friendItem, friendIndex) in item.friend"
                                        @contextmenu.prevent="openUserMenu($event, friendItem.id, friendItem, friendIndex)">
                                        <div class="userInfo">
                                            <el-avatar :class="friendItem.fd? 'fl' : 'fl friend-list-off-line'"
                                                       :size="50" :src="friendItem.avatar"></el-avatar>
                                            <div class="fl" style="margin-left: 10px;">
                                                <div class="username">{{friendItem.name}}</div>
                                                <div class="userSignature">{{friendItem.signature}}</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </el-col>
                <el-col :span="24" class="tool">
                    <el-row>
                        <el-col title="系统消息通知" :span="6">
                            <el-badge :value="$store.state.friendPanelTool.systemNotifyNum">
                                <svg class="icon " aria-hidden="true">
                                    <use xlink:href="#icon-iconset0274"></use>
                                </svg>
                            </el-badge>
                        </el-col>
                        <el-col title="添加好友" :span="6" @click.native="openAddFriendDialog($event)">
                            <el-badge :value="$store.state.friendPanelTool.friendNotifyNum">
                                <svg class="icon " aria-hidden="true">
                                    <use xlink:href="#icon-add"></use>
                                </svg>
                            </el-badge>
                        </el-col>
                        <el-col title="分享聊天室给你的好友" :span="6">
                            <el-badge :value="$store.state.friendPanelTool.shareNotifyNum">
                                <svg class="icon " aria-hidden="true">
                                    <use xlink:href="#icon-fenxiang2"></use>
                                </svg>
                            </el-badge>
                        </el-col>
                    </el-row>
                </el-col>
            </el-row>
        </div>
        <el-dialog title="添加新分栏" :visible.sync="newColumnBox" :close-on-click-modal="false" width="30%">
            <el-input v-model="newColumnName"></el-input>
            <span slot="footer" class="dialog-footer">
              <el-button @click="newColumnBox = false">取 消</el-button>
              <el-button type="primary" @click="addColumn">确 定</el-button>
            </span>
        </el-dialog>

        <el-dialog title="修改分栏名称" :visible.sync="editColumnBox" :close-on-click-modal="false" width="30%">
            <el-input v-model="newColumnName"></el-input>
            <span slot="footer" class="dialog-footer">
              <el-button @click="editColumnBox = false">取 消</el-button>
              <el-button type="primary" @click="updateColumnInfo">确 定</el-button>
            </span>
        </el-dialog>

        <el-dialog title="好友信息" :visible.sync="friendInfoBox" width="30%">
            <table cellpadding="5" cellspacing="5">
                <tr>
                    <td style="color:red">
                        <svg class="icon " aria-hidden="true">
                            <use xlink:href="#icon-ziyuan"></use>
                        </svg>
                    </td>
                    <td>{{currentHandelUserObj.phone}}</td>
                </tr>
                <tr>
                    <td style="color: deepskyblue;">
                        <svg class="icon " aria-hidden="true">
                            <use xlink:href="#icon-yonghuming"></use>
                        </svg>
                    </td>
                    <td>{{currentHandelUserObj.name}}</td>
                </tr>
                <tr>
                    <td style="color: #26352a;">
                        <svg class="icon " aria-hidden="true">
                            <use xlink:href="#icon-qianming"></use>
                        </svg>
                    </td>
                    <td>{{currentHandelUserObj.signature}}</td>
                </tr>
                <tr>
                    <td style="color: #2e2cbf;">
                        <svg class="icon " aria-hidden="true">
                            <use xlink:href="#icon-fenzu"></use>
                        </svg>
                    </td>
                    <td>{{currentHandelColumnObj.name}}</td>
                </tr>
                <tr>
                    <td style="color:#1e3a34">
                        <svg class="icon " aria-hidden="true">
                            <use xlink:href="#icon-shijian"></use>
                        </svg>
                    </td>
                    <td>{{currentHandelUserObj.created_at}}</td>
                </tr>
            </table>
        </el-dialog>

        <el-dialog title="添加好友" @close="closeAddFriendDialog()" :visible.sync="addFriend" :close-on-click-modal="false">
            <el-tabs style="height: 390px" tab-position="left">
                <el-tab-pane label="查找好友">

                    <div class="search-main" v-if="search">
                        <el-row class="search">
                            <el-col :offset="2" :span="13">
                                <el-input type="number" v-model="searchFriendPhone"
                                          placeholder="对方手机号码,可模糊搜索"></el-input>
                            </el-col>
                            <el-col :offset="1" :span="8">
                                <el-button type="success" @click="searchPhone(1)">
                                    <svg class="icon " aria-hidden="true">
                                        <use xlink:href="#icon-chaxun1"></use>
                                    </svg>
                                    查找
                                </el-button>
                            </el-col>
                        </el-row>
                    </div>

                    <div v-if="searchResult">
                        <div @click="backSearch" class="backSearch" style="text-align: center;">
                            <svg class="icon " aria-hidden="true">
                                <use xlink:href="#icon-jiantou"></use>
                            </svg>
                        </div>
                        <ul class="searchResult-list">
                            <li v-for="userItem in searchUserResult">
                                <div style="height: 100%" class="fl">
                                    <el-avatar style="position: relative; top: 15%; margin-right: 20px"
                                               :class="userItem.fd? 'fl' : 'fl friend-list-off-line'" :size="50"
                                               :src="userItem.avatar">
                                    </el-avatar>
                                </div>
                                <p class="searchResult-p-nowrap">{{userItem.name}}</p>
                                <p class="searchResult-p-nowrap">{{userItem.signature}}</p>
                                <p v-html="userItem.phone"></p>
                                <p>
                                    <el-button type="success" size="mini" @click="openSendVerfMsgDialog(userItem)">
                                        <svg class="icon " aria-hidden="true">
                                            <use xlink:href="#icon-add"></use>
                                        </svg>
                                        添加好友
                                    </el-button>
                                </p>
                            </li>
                            <div style="clear: both"></div>
                        </ul>
                    </div>

                    <div v-if="searchResult">
                        <el-row>
                            <el-col :offset="7" :span="5">
                                <el-button size="mini" :disabled="searchPhoneUp" type="success"
                                           @click="searchPhone(--searchPhonePage)">
                                    <svg class="icon" aria-hidden="true">
                                        <use xlink:href="#icon-jiantou-shang"></use>
                                    </svg>
                                </el-button>
                            </el-col>
                            <el-col :span="12">
                                <el-button size="mini" :disabled="searchPhoneNext" type="success"
                                           @click="searchPhone(++searchPhonePage)">
                                    <svg class="icon" aria-hidden="true">
                                        <use xlink:href="#icon-jiantou-copy-copy"></use>
                                    </svg>
                                </el-button>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>

                <el-tab-pane label="添加好友消息">
                    <el-row v-for="(item, index) in friendAuthList" :key="index">
                        <div style="height: 85px">
                            <el-col :offset="1" :span="3">
                                <el-avatar
                                        :class="item.friend.fd? 'fl' : 'fl friend-list-off-line'" :size="50"
                                        :src="item.friend.avatar">
                                </el-avatar>
                            </el-col>
                            <el-col :span="12">
                                <div style="overflow: hidden;width: 250px">
                                    <p>{{item.friend.name}}</p>
                                    <p>{{item.friend.phone}}</p>
                                    <p>{{item.msg}}</p>
                                </div>
                            </el-col>
                            <el-col :span="8">
                                <div style="margin-top: 15px">
                                    <template v-if="item.status == 0">
                                        <el-button type="success" size="mini" @click="handelFriendAuth(item.friend_id)">同意</el-button>
                                        <el-button type="warning" size="mini" @click="openRefuseFriendAuthDialog(item.friend_id)">拒绝</el-button>
                                    </template>
                                    <template v-else-if="item.status == 1">
                                        <el-button type="success" :disabled="true" title="您已同意添加他为好友" size="mini">同意
                                        </el-button>
                                        <el-button type="warning" :disabled="true" title="您已同意添加他为好友" size="mini">拒绝
                                        </el-button>
                                    </template>
                                    <template v-else-if="item.status == 2">
                                        <el-button type="success" :disabled="true" title="您已拒绝添加他为好友" size="mini">同意
                                        </el-button>
                                        <el-button type="warning" :disabled="true" title="您已拒绝添加他为好友" size="mini">拒绝
                                        </el-button>
                                    </template>
                                </div>
                            </el-col>
                        </div>
                    </el-row>
                    <div>
                        <el-row>
                            <el-col :offset="7" :span="5">
                                <el-button size="mini" :disabled="friendAuthUp"  type="success" @click="getFriendAuth(--friendAuthPage)">
                                    <svg class="icon" aria-hidden="true">
                                        <use xlink:href="#icon-jiantou-shang"></use>
                                    </svg>
                                </el-button>
                            </el-col>
                            <el-col :span="12">
                                <el-button size="mini" :disabled="friendAuthNext"  type="success" @click="getFriendAuth(++friendAuthPage)">
                                    <svg class="icon" aria-hidden="true">
                                        <use xlink:href="#icon-jiantou-copy-copy"></use>
                                    </svg>
                                </el-button>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>

            </el-tabs>
        </el-dialog>

        <el-dialog title="发送验证信息" :visible.sync="sendAddFriendMsgDialog" :close-on-click-modal="false">
            <el-row>
                <el-col :span="2">
                    <el-avatar style="margin-top: 10px"
                               :class="currentHandelUserObj.fd? 'fl' : 'fl friend-list-off-line'" :size="50"
                               :src="currentHandelUserObj.avatar">
                    </el-avatar>
                    <p>
                        <b>{{currentHandelUserObj.name}}</b>
                    </p>
                </el-col>
                <el-col :span="12">
                    <p>请输入验证信息:</p>
                    <el-input v-model="verfMSG"></el-input>
                </el-col>
                <el-col :span="4" :offset="1">
                    <el-button type="success" style="margin-top: 20px" @click="sendAddFriend(currentHandelUserObj.id)">
                        发送
                    </el-button>
                </el-col>
            </el-row>
        </el-dialog>

        <el-dialog title="拒绝好友" :visible.sync="RefuseFriendAuthDialog" :close-on-click-modal="false">
            <el-row>
                <el-col :span="18">
                    <el-input v-model="reason" placeholder="拒绝理由"></el-input>
                </el-col>
                <el-col :offset="1" :span="4">
                    <el-button type="success" @click="refuseFriendAuth">确定</el-button>
                </el-col>
            </el-row>
        </el-dialog>
    </div>
</template>

<script>
    import {
        columnFriend, storeColumn,
        destroyColumn, updateColumn,
        destroyFriend, searchFriend,
        storeFriend, storeFriendAuth,
        friendAuth
    } from '@/api/friend';
    import wsk from '@/libs/wsk';

    import {mapActions} from 'vuex'

    export default {
        name: "friendPanel",
        data() {
            return {
                sendAddFriendMsgDialog: false,
                RefuseFriendAuthDialog: false,
                columnFriend: [],
                systemMenu: [],
                searchFriendPhone: "",
                verfMSG: "我是...",
                searchUserResult: [],
                newColumnBox: false,
                editColumnBox: false,
                friendInfoBox: false,
                addFriend: false,
                search: true,
                searchResult: false,
                newColumnName: "",
                currentHandelColumnId: 0,
                currentHandelColumnObj: "",
                currentHandelColumnIndex: "",
                searchPhoneUp: true,
                searchPhoneNext: false,
                friendAuthUp:true,
                friendAuthNext:false,
                currentHandelUserId: 0,
                currentHandelUserObj: "",
                currentHandelUserIndex: "",
                searchUserTotal: 0,
                searchPhonePage: 0,
                searchPhoneLimit: 6,
                friendAuthList: [],
                friendAuthPage: 0,
                reason:''
            }
        },
        created() {
            window.onclick = function (e) {
                window.document.querySelector('#systemMenu').style.display = "none";
                window.document.querySelector('#columnMenu').style.display = "none";
                window.document.querySelector('#userMenu').style.display = "none";
            };
            //拉取分栏及好友信息
            this.getColumnFriend();
            this.friendAuthNum();
            friendAuth(++this.friendAuthPage, 4).then((response) => {
                this.friendAuthList = response.data.data;
            });
        },
        mounted(){
            wsk.sendBindFd();
        },
        methods: {
            ...mapActions([
                'friendAuthNum',
            ]),

            openList(index) {

                if (this.getIdDom('sj' + index).getAttribute('xlink:href') === "#icon-sanjiao") {
                    this.getIdDom('friendColumn' + index).style.display = "none";
                    this.getIdDom('sj' + index).setAttribute('xlink:href', '#icon-yousanjiaoxing');
                    let domAll = this.getClassDomAll('column');
                    domAll.forEach(item => {
                        item.className = 'column columnHover';
                    })
                } else {
                    this.getIdDom('sj' + index).setAttribute('xlink:href', '#icon-sanjiao');
                    this.getIdDom('friendColumn' + index).style.display = "";
                    //移除 class 让他找不到元素就不触发hover了
                    let domAll = this.getClassDomAll('columnHover');
                    domAll.forEach(item => {
                        item.className = 'column';
                    });
                }
            },

            /**
             * 拉取分栏及好友列表
             */
            getColumnFriend() {
                columnFriend().then((response) => {
                    this.$store.commit('setColumnFriend', response.data.data);
                })
            },

            /**
             * 关闭右键菜单
             */
            closeMenu(menuId = 'all') {
                if (menuId === 'all') {
                    this.getIdDom('systemMenu').style.display = "none";
                    this.getIdDom('columnMenu').style.display = "none";
                    this.getIdDom('userMenu').style.display = "none";
                } else {
                    this.getIdDom(menuId).style.display = "none";
                }
            },

            /**
             * 打开右键菜单
             */
            openMenu(menuId = 'all', event) {
                if (menuId === 'all') {
                    this.getIdDom('systemMenu').style.display = "";
                    this.getIdDom('columnMenu').style.display = "";
                } else {
                    let menu = this.getIdDom(menuId);
                    //根据事件对象中鼠标点击的位置，进行定位
                    menu.style.left = event.layerX + 'px';
                    menu.style.top = event.clientY + 'px';
                    menu.style.display = '';
                    //阻止事件冒泡
                    event.stopPropagation();
                }
            },

            /**
             * 系统右键菜单开关
             *
             * @param e
             */
            openSystemMenu(e) {
                //关闭所有右键菜单
                this.closeMenu();
                this.openMenu('systemMenu', e);
            },

            //打开栏目菜单
            openColumnMenu(e, id, obj, index) {
                this.currentHandelColumnId = id;
                //当前操作分栏的数据对象
                this.currentHandelColumnObj = obj;
                //当前操作分栏索引位置
                this.currentHandelColumnIndex = index;
                //关闭所有右键菜单
                this.closeMenu();
                this.openMenu('columnMenu', e);
            },

            /**
             * 打开用户层的右键菜单
             */
            openUserMenu(e, id, item, index) {
                this.currentHandelUserId = id;
                this.currentHandelUserObj = item;
                this.currentHandelUserIndex = index;

                //关闭所有右键菜单
                this.closeMenu();
                this.openMenu('userMenu', e);
            },

            /**
             * 系统反馈
             */
            feedBack() {
                this.$message.info('暂未开放')
            },

            /**
             * 添加新分栏
             */
            addColumnBoxOpen() {
                this.newColumnBox = true;
            },

            /**
             * 存储栏目
             */
            addColumn() {
                if (this.newColumnName == '') {
                    this.$message.warning('新分栏的名字不应该为空');
                    return;
                }
                storeColumn({name: this.newColumnName}).then((response) => {
                    this.columnFriend.push({
                        name: this.newColumnName,
                        friend: [],
                        id: response.data.data.id
                    });
                    this.newColumnName = "";
                    this.newColumnBox = false;
                });
            },

            /**
             * 根据class名找dom
             *
             * @param className
             * @returns {Element}
             */
            getClassDom(className) {
                return window.document.querySelector('.' + className)
            },

            /**
             * 根据class名称查找所有Dom
             */
            getClassDomAll(className) {
                return window.document.querySelectorAll('.' + className)
            },

            /**
             * 根据domId查找元素
             *
             * @param id
             * @returns {Element}
             */
            getIdDom(id) {
                return window.document.querySelector('#' + id)
            },

            /**
             * 删除分栏
             */
            destroyColumnInfo() {
                destroyColumn(this.currentHandelColumnId).then((response) => {
                    this.columnFriend.splice(this.currentHandelColumnIndex, 1);
                    this.currentHandelColumnId = 0;
                    //重新拉取分栏及好友信息
                    this.getColumnFriend();
                    this.$message.success(response.data.msg)
                });
            },

            /**
             * 重命名分栏弹窗
             */
            editColumn() {
                this.newColumnName = this.currentHandelColumnObj.name;
                this.editColumnBox = true;
            },

            /**
             * 更新分栏
             */
            updateColumnInfo() {
                updateColumn(this.currentHandelColumnId, {name: this.newColumnName}).then((response) => {
                    this.columnFriend.forEach(item => {
                        if (item.id == this.currentHandelColumnId) {
                            //刷新名称
                            item.name = this.newColumnName;
                        }
                    });
                    //回归状态
                    this.currentHandelColumnId = 0;
                    this.newColumnName = "";
                    this.editColumnBox = false;
                    this.$message.success(response.data.msg)
                });
            },

            /**
             * 展开分栏
             */
            openColumn() {
                this.openList(this.currentHandelColumnIndex);
            },

            /**
             * 发送消息
             */
            sendMsg() {
                this.$store.commit('setFriendList',this.currentHandelUserObj);
            },

            /**
             * 删除好友
             */
            deleteFriend() {
                this.$confirm('是否确定删除:' + this.currentHandelUserObj.name + ',这个好友?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    destroyFriend(this.currentHandelUserId).then((response) => {
                        //动态移除占位
                        this.columnFriend.forEach((colItem, colIndex) => {
                            colItem.friend.forEach((friendItem, friIndex) => {
                                if (friendItem.id == this.currentHandelUserId) {
                                    this.columnFriend[colIndex].friend.splice(this.currentHandelUserIndex, 1);
                                }
                            })
                        });
                        this.$message.success(response.data.msg);
                    })
                }).catch(() => {
                    //nothing
                });

            },

            /**
             * 查看用户信息
             */
            showUserInfo() {
                this.userIdMappingColumn(this.currentHandelUserId)
                this.friendInfoBox = true;

            },

            /**
             * userId 对应的那一层的分栏信息
             *
             * @param userId
             */
            userIdMappingColumn(userId) {
                for (let columnItem = 0; columnItem < this.columnFriend.length; columnItem++) {
                    for (let friendItem = 0; friendItem < this.columnFriend[columnItem].friend.length; friendItem++) {
                        if (this.columnFriend[columnItem].friend[friendItem].id == this.currentHandelUserId) {
                            this.currentHandelColumnObj = this.columnFriend[columnItem];
                            return this.currentHandelColumnObj
                        }
                    }
                }
            },

            /**
             * 打开好友添加信息窗口
             */
            openAddFriendDialog() {
                this.addFriend = true;
            },

            /**
             * 关闭搜索框
             */
            closeAddFriendDialog() {
                this.addFriend = false;
                this.search = true;
                this.searchResult = false;
                this.searchFriendPhone = "";
            },

            /**
             * 手机号码检测
             *
             * @param phone
             * @returns {boolean}
             */
            phoneCheck(phone) {
                let myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
                if (!myreg.test(phone)) {
                    return false;
                } else {
                    return true;
                }
            },

            /**
             * 搜索好友
             *
             * @param page
             */
            searchPhone(page) {
                this.searchPhonePage = page;

                if (this.searchPhonePage <= 0) {
                    this.searchPhonePage = 1;
                }

                if (this.searchPhonePage == 1) {
                    //向上按钮无法使用
                    this.searchPhoneUp = true;
                } else {
                    this.searchPhoneUp = false;
                }

                searchFriend({phone: this.searchFriendPhone}, page, this.searchPhoneLimit).then((response) => {
                    this.search = false;
                    this.searchResult = true;
                    this.searchUserResult = response.data.data.users;
                    this.searchUserTotal = response.data.data.total;
                    //向上去整得出最大页数
                    let totalPage = Math.ceil(this.searchUserTotal / this.searchPhoneLimit);
                    if (this.searchPhonePage >= totalPage) {
                        //超出页数无法继续
                        this.searchPhoneNext = true;
                    } else {
                        this.searchPhoneNext = false;
                    }
                })

            },

            /**
             * 返回搜索页
             */
            backSearch() {
                this.search = true;
                this.searchResult = false;
            },

            /**
             * 打开好友添加确认信息
             */
            openSendVerfMsgDialog(user) {
                this.currentHandelUserObj = user;
                this.sendAddFriendMsgDialog = true
            },

            /**
             * 指定好友Id是否存在
             */
            isExistFriend(friendId) {
                for (let columnIndex = 0; columnIndex < this.columnFriend.length; columnIndex++) {
                    for (let friendIndex = 0; friendIndex < this.columnFriend[columnIndex].friend.length; friendIndex++) {
                        if (this.columnFriend[columnIndex].friend[friendIndex].id == friendId) {
                            return true
                        }
                    }
                }
                return false;
            },

            /**
             * 发送添加好友信息
             *
             * @param friendId
             */
            sendAddFriend(friendId) {
                //要添加的人是否已是他的好友
                let isExist = this.isExistFriend(friendId);
                if (isExist) {
                    this.$message.error('该好友已存在您的好友列表中无法继续添加');
                    return
                }
                storeFriendAuth({friend_id: friendId, msg: this.verfMSG}).then((response) => {
                    this.$message.success(response.data.msg);
                    this.sendAddFriendMsgDialog = false;
                })
            },

            /**
             * 获得好友认证消息
             *
             * @param page
             */
            getFriendAuth(page) {
                this.friendAuthPage = page;

                if (this.friendAuthPage <= 0) {
                    this.friendAuthPage = 1;
                }

                if (this.friendAuthPage == 1) {
                    //向上按钮无法使用
                    this.friendAuthUp = true;
                } else {
                    this.friendAuthUp = false;
                }

                friendAuth(this.friendAuthPage, 4).then((response) => {
                    this.friendAuthList = response.data.data;
                    //向上去整得出最大页数
                    let totalPage = Math.ceil(response.data.total / 4);
                    if (this.friendAuthPage >= totalPage) {
                        //超出页数无法继续
                        this.friendAuthNext = true;
                    } else {
                        this.friendAuthNext = false;
                    }
                });
            },

            /**
             * 处理好友信息
             *
             * @param friendId
             * @param status
             */
            handelFriendAuth(friendId) {
                this.currentHandelUserId = friendId;
                storeFriend({friend_id:friendId, status:1, reason:this.reason}).then((response)=>{
                    this.changeFriendAuthButtonStatus(friendId, 1);
                    this.$message.success(response.data.msg);
                })
            },
            /**
             * 打开拒绝窗口
             * @param friendId
             */
            openRefuseFriendAuthDialog(friendId){
                this.RefuseFriendAuthDialog = true;
                this.currentHandelUserId = friendId;
            },
            /**
             * 该变好友按钮状态
             */
            changeFriendAuthButtonStatus(friendId, status) {
                this.friendAuthList.forEach(item=>{
                    if (item.friend_id == this.currentHandelUserId) {
                        //改变状态
                        item.status = status;
                    }
                });
            },

            /**
             * 发送拒绝信息
             */
            refuseFriendAuth() {
                storeFriend({friend_id:this.currentHandelUserId, status:2, reason:this.reason}).then((response)=>{
                    this.$message.success(response.data.msg);
                    this.RefuseFriendAuthDialog = false;
                    this.reason = "";
                    this.changeFriendAuthButtonStatus(this.currentHandelUserId, 2);
                    //通知动态减数
                    this.$store.commit('setFriendNotifyNum',  --this.$store.state.friendPanelTool.friendNotifyNum)
                })
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
        padding: 10px 0 10px 0;
        /*overflow: hidden;*/
        /*height: 20px;*/
    }

    .columnHover:hover {
        background: #eeeeee;
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

    .userInfo:hover {
        /*border: 1px solid #1b1e21;*/
        background: #f2f2f2;
    }

    .tool {
        border-top: 1px solid #eee;
        font-size: 25px;
        text-align: center;
    }

    .tool .el-col-6:hover {
        background: #d5d5d5;
    }

    .contextMenu {
        z-index: 2;
        position: absolute; /*自定义菜单相对与body元素进行定位*/
        width: 180px;
        /*height: 130px;*/
        background: #d5d5d5;
    }

    .contextMenu-item {
        padding: 5px;
        border: 1px solid #e0e5ea;
    }

    .contextMenu-item:hover {
        background: #f5f5f5;
    }

    .hidden {
        display: none;
    }

    .friend-list-off-line {
        filter: grayscale(1);
        opacity: 0.8;
    }

    tr td:nth-child(2) {
        padding-left: 10px;
    }

    .search-main {
        margin-bottom: 100px;
        margin-top: 50px;
        height: 200px;
        background: #d6d6d6;
    }

    .search {
        margin: 0 auto;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }

    .backSearch {
        font-size: 18px;
        height: 30px;
        width: 30px;
    }

    .backSearch:hover {
        background: #eeeeee;
    }

    .searchResult-list {
        margin-top: 20px;
        height: 300px;
    }

    .searchResult-list > li {
        height: 100px;
        width: 210px;
        float: left;
        margin-right: 30px;
    }

    .searchResult-list p {
        width: 130px;
        overflow: hidden;
    }

    .searchResult-p-nowrap {
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .searchPhoneNextPage {
        position: relative;
        text-align: center;
        right: 7%;
        font-size: 20px;
    }
</style>
