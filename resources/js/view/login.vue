<template>
    <div class="login">
        <div class="loginDlog">
            <div class="body">
                <div class="content-left">
                    <h1 class="logo">
                        <a></a>
                    </h1>
                    <div class="up-form-width">
                        <el-form ref="form" :model="form" label-width="80px">
                            <el-form-item label="手机号">
                                <el-input style="width: 250px" v-model="form.phone "></el-input>
                            </el-form-item>
                            <el-form-item label="密  码">
                                <el-input style="width: 250px" type="password" v-model="form.password"></el-input>
                            </el-form-item>
                            <el-form-item style="margin-bottom:0!important;">
                                <a @click="forgetPwd" class="forget-password">忘记密码?</a>
                                <a @click="register" class="forget-password">注册账号</a>
                                <el-button style="padding: 10px 30px;" type="success" size="small" @click="onSubmit">
                                    <svg class="icon " aria-hidden="true">
                                        <use xlink:href="#icon-denglu"></use>
                                    </svg>
                                    登录
                                </el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
                <div class="content-right">
                    <h3 class="oauth-text">第三方账号登录</h3>
                    <ul class="oauth">
                        <li>
                            <el-button class="oauth-bt" type="danger" @click="wbLogin">
                                <svg class="icon " aria-hidden="true">
                                    <use xlink:href="#icon-552cd5bdeaada"></use>
                                </svg>
                                微博登录
                            </el-button>
                        </li>
                        <li>
                            <el-button class="oauth-bt" type="primary" @click="qqLogin">
                                <svg class="icon " aria-hidden="true">
                                    <use xlink:href="#icon-qq"></use>
                                </svg>
                                QQ登录</el-button>
                        </li>
                        <li>
                            <el-button class="oauth-bt" type="success" @click="wxLogin">
                                <svg class="icon " aria-hidden="true">
                                    <use xlink:href="#icon-552cd5c76f532"></use>
                                </svg>
                                微信登录</el-button>
                        </li>
                    </ul>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="loginDlog-footer">
                <div style="float: left;margin-right: 10px">
                    <img src="/img/company_logo.png" alt="">
                </div>
                <div class="loginDlog-footer-text">
                    <p> 当前版本:V 1.0.0</p>
                    <p> 欢迎回来!</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapActions} from 'vuex'
    export default {
        data() {
            return {
                form: {
                    phone: '',
                    password: '',
                }
            }
        },
        methods: {
            ...mapActions([
                'handleLogin',
            ]),
            onSubmit() {
                this.handleLogin(this.form).then(res => {
                    if (res.code == 0) {
                        this.$message.success('登陆成功');
                        this.$router.push('/home');
                    } else {
                        this.$message.error('登陆失败');
                    }
                })
            },
            wbLogin(){
                this.$message.info('暂未开放')
            },
            wxLogin(){
                this.$message.info('暂未开放')
            },
            qqLogin(){
                this.$message.info('暂未开放')
            },
            forgetPwd(){
                this.$message.success('请联系管理员')
            },
            register(){
                this.$router.push('/register');
            }
        }
    }
</script>

<style scoped>
    .loginDlog-footer-text p {
        line-height: 30px;
    }
    .forget-password {
        margin-right: 10px;
        text-decoration: none;
        color: #666666;
    }
    .content-left {
        float: left;
        width: 300px;
        margin-right: 60px;
    }
    .body {
        padding: 40px 60px;
        overflow: hidden;
    }
    .content-right {
        float: left;
        padding: 60px 0 60px 60px;
        border-left: 1px solid #e6e6e6;
    }
    .oauth-bt {
        width: 170px;
    }
    .oauth {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .oauth li {
        line-height: 55px;
    }
    .oauth-text {
        margin-top: 0;
        font-size: 100%;
        font-weight: 500;
        line-height: 1.7;
        margin-bottom: 27px;
        color: #666666;
        text-align: center;
    }
    .login {
        width: 100%;
        height: 100%;
        background-color: #487779;
    }
    .loginDlog {
        background-color: white;
        width: 715px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    .loginDlog-footer {
        height: 70px;
        background-color: #f5f5f5;
        padding: 0 60px;
        color: #66b7ff;
    }
    .logo {
        width: 240px;
        height: 94px;
        background: url(/img/logo.png) no-repeat;
    }
    .logo a {
        display: block;
        width: 151px;
        height: 94px;
    }
    .up-form-width {
        width: 100%
    }
    .up-form-width >>> .el-form-item__content {
        width: 100% !important;
    }
</style>