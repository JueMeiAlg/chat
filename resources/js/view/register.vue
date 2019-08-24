<template>
    <div class="register-main-box">
        <div style="margin-top: 15px; width: 80%;">
            <el-form ref="form" :model="form" :rules="rules" label-width="80px">
                <el-form-item label="手机号码" prop="phone">
                    <el-input v-model.number="form.phone" placeholder="不认证手机号可以输入任意数字"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password">
                    <el-input v-model="form.password"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="success" @click="submit">注册</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
    import {register} from '@/api/user';

    export default {
        name: "register",
        data() {
            return {
                form: {
                    phone: "",
                    password: "",
                },
                rules: {
                    password: [
                        {min: 6, message: '密码最少六位', trigger: 'blur'},
                        {required: true, message: '密码需要填写', trigger: 'blur'},
                    ],
                    phone:[
                        {required: true, message: '手机号(账号)不能为空可以填写任意11位数字'},
                        {type: 'number', message: '必须为数字'}
                    ]
                }
            }
        },
        methods: {
            submit() {
                let phoneLength = this.form.phone.toString().length;

                if (phoneLength> 11 || phoneLength < 11) {
                    this.$message.error(`手机号(账号)位数不对只能11位当前${phoneLength}位`);
                    return
                }

                this.$refs['form'].validate((valid) => {
                    if (valid) {
                        register(this.form).then((response)=>{
                            this.$router.push('/')
                        })
                    } else {
                       this.$message.error('验证信息不通过');
                        return false;
                    }
                });
            },
        }
    }
</script>

<style scoped>
    .register-main-box {
        border: 1px solid #eeeeee;
        height: 200px;
        width: 400px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        background: #cccccc;
    }
</style>