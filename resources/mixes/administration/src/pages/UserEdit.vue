<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/members/${to.params.id}/show`).then(response => {
                next(vm => {
                    vm.form = response.data.data;
                    injection.loading.done();
                    injection.sidebar.active('member');
                });
            });
        },
        data() {
            return {
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
                    phone: '',
                    points: '',
                    real_name: '',
                    sex: '',
                    signature: '',
                },
                rules: {},
            };
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
                            <form-item label="头像" prop="avatar">
                                <upload ref="upload"
                                        :show-upload-list="false"
                                        :default-file-list="defaultList"
                                        :on-success="handleSuccess"
                                        :format="['jpg','jpeg','png']"
                                        :max-size="2048"
                                        :on-format-error="handleFormatError"
                                        :on-exceeded-size="handleMaxSize"
                                        :before-upload="handleBeforeUpload"
                                        action="//jsonplaceholder.typicode.com/posts/"
                                        style="display: inline-block;width:58px;">
                                    <div style="width: 58px;height:58px;line-height: 58px;">
                                        <icon type="plus" size="20"></icon>
                                    </div>
                                </upload>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="E-mail" prop="mail">
                                <i-input placeholder="请输入电子邮件" v-model="form.mail"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="邮箱激活状态">
                            </form-item>
                        </i-col>
                    </row>
                    <p class="extend-title">用户栏目</p>
                    <row>
                        <i-col span="14">
                            <form-item label="性别">
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="生日">
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="自我介绍" prop="users">
                                <i-input type="textarea" placeholder="请输入自我介绍" v-model="form.users"
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
