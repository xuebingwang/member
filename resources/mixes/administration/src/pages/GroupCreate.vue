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
                form: {
                    avatar: '',
                    name: '',
                    users: '',
                },
                rules: {
                    name: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入用户组名称',
                            trigger: 'change',
                        },
                    ],
                },
            };
        },
        methods: {
            submit() {
                const self = this;
                self.loading = true;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
        },
        mounted() {
            this.$store.commit('title', injection.trans('administration.title.setting'));
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="group-create">
            <card>
                <p slot="title">新建用户组</p>
                <div class="extend-info">
                    <p>提示</p>
                    <p>用户组合并可将源用户组的用户合并进入所选的新用户组，并且可以选择删除源用户组。</p>
                    <p>用户组合并不可以操作管理组。</p>
                    <p>用户组合并一旦提交立即生效，并无法恢复，请仔细选择目标用户组和设置项目。</p>
                </div>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="14">
                            <form-item label="用户组名称" prop="name">
                                <i-input placeholder="请输入用户组名称" v-model="form.name"></i-input>
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
                            <form-item label="添加用户" prop="users">
                                <i-input type="textarea" placeholder="请输入统计代码" v-model="form.users"
                                         :autosize="{minRows: 5,maxRows: 9}"></i-input>
                                <p class="info">每行输入一个用户名</p>
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
