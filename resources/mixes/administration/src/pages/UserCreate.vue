<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('member');
            });
        },
        data() {
            return {
                action: `${window.api}/member/upload`,
                form: {
                    age: '',
                    avatar: '',
                    birthday: '',
                    created_at: '',
                    email: '',
                    group: '',
                    id: 1,
                    introduction: '',
                    name: '',
                    nick_name: '',
                    password: '',
                    phone: '',
                    points: '',
                    real_name: '',
                    sex: '',
                    signature: '',
                },
                loading: false,
                sex: [
                    {
                        label: '男',
                        value: '男',
                    },
                    {
                        label: '女',
                        value: '女',
                    },
                    {
                        label: '保密',
                        value: '保密',
                    },
                ],
                rules: {
                    email: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入用户名',
                            trigger: 'change',
                        },
                    ],
                    name: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入用户名',
                            trigger: 'change',
                        },
                    ],
                    password: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入密码',
                            trigger: 'change',
                        },
                    ],
                },
                trans: injection.trans,
            };
        },
        methods: {
            dateChange(val) {
                this.form.birthday = val;
            },
            removeAvatar() {
                this.form.avatar = '';
            },
            submit() {
                const self = this;
                self.loading = true;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        const data = self.form;
                        if (self.form.sex === '男') {
                            data.sex = 1;
                        } else if (self.form.sex === '女') {
                            data.sex = 2;
                        } else {
                            data.sex = 0;
                        }
                        self.$http.post(`${window.api}/member/members/create`, data).then(() => {
                            self.$notice.open({
                                title: '添加用户成功！',
                            });
                            self.$router.push('/member/user');
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.$notice.error({
                            title: '请正确填写用户信息',
                        });
                        self.loading = false;
                    }
                });
            },
            uploadBefore() {
                injection.loading.start();
            },
            uploadError(error, data) {
                const self = this;
                injection.loading.error();
                if (typeof data.message === 'object') {
                    for (const p in data.message) {
                        self.$notice.error({
                            title: data.message[p],
                        });
                    }
                } else {
                    self.$notice.error({
                        title: data.message,
                    });
                }
            },
            uploadFormatError(file) {
                this.$notice.warning({
                    title: '文件格式不正确',
                    desc: `文件 ${file.name} 格式不正确，请上传 jpg 或 png 格式的图片。`,
                });
            },
            uploadSuccess(data) {
                const self = this;
                injection.loading.finish();
                self.$notice.open({
                    title: data.message,
                });
                self.form.avatar = data.data.path;
            },
        },
        mounted() {
            this.$store.commit('title', '用户详情 - 用户中心');
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-create">
            <card>
                <p slot="title">用户详情</p>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <p class="extend-title">基本资料</p>
                    <row>
                        <i-col span="14">
                            <form-item label="用户名" prop="name">
                                <i-input placeholder="请输入用户名" v-model="form.name"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="密码" prop="name">
                                <i-input placeholder="请输入密码" v-model="form.password"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="头像" prop="avatar">
                                <div class="image-preview" v-if="form.avatar">
                                    <img :src="form.avatar">
                                    <icon type="close" @click.native="removeAvatar"></icon>
                                </div>
                                <upload :action="action"
                                        :format="['jpg','jpeg','png']"
                                        :headers="{
                                            Authorization: `Bearer ${$store.state.token.access_token}`
                                        }"
                                        :max-size="2048"
                                        :on-error="uploadError"
                                        :on-format-error="uploadFormatError"
                                        :on-success="uploadSuccess"
                                        ref="upload"
                                        :show-upload-list="false"
                                        v-if="form.avatar === ''">
                                </upload>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="E-mail" prop="email">
                                <i-input placeholder="请输入电子邮件" v-model="form.email"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="邮箱激活状态">
                                <radio-group v-model="form.enabled" size="large">
                                    <radio label="1">
                                        <span>已激活</span>
                                    </radio>
                                    <radio label="android">
                                        <span>未激活</span>
                                    </radio>
                                </radio-group>
                            </form-item>
                        </i-col>
                    </row>
                    <p class="extend-title">用户栏目</p>
                    <row>
                        <i-col span="14">
                            <form-item label="性别">
                                <i-select v-model="form.sex">
                                    <i-option v-for="item in sex" :value="item.value" :key="item">{{ item.label }}</i-option>
                                </i-select>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="生日">
                                <date-picker :placeholder="trans('content.article.form.date.placeholder')"
                                             type="date"
                                             :value="form.birthday"
                                             @on-change="dateChange"></date-picker>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="自我介绍" prop="users">
                                <i-input type="textarea" placeholder="请输入自我介绍" v-model="form.signature"
                                         :autosize="{minRows: 5,maxRows: 9}"></i-input>
                                <p class="info">自我介绍将显示在您的主页上方，不填写则不显示</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item>
                                <i-button :loading="loading" type="primary" @click.native="submit">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </i-col>
                    </row>
                </i-form>
            </card>
        </div>
    </div>
</template>
