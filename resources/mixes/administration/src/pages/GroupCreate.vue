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
                    avatar: '',
                    description: '',
                    identification: '',
                    name: '',
                    users: '',
                },
                loading: false,
                rules: {
                    identification: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入用户组标识',
                            trigger: 'change',
                        },
                    ],
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
            removeAvatar() {
                this.form.avatar = '';
            },
            submit() {
                const self = this;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        self.loading = true;
                        const data = {
                            description: self.form.description,
                            display_name: self.form.name,
                            name: self.form.identification,
                        };
                        self.$http.patch(`${window.api}/member/groups/store`, data).then(() => {
                            self.$notice.open({
                                title: '添加用户组成功！',
                            });
                            self.$router.push('/member/group');
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
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
                            <form-item label="用户组标识" prop="identification">
                                <i-input placeholder="请输入用户组标识" v-model="form.identification"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="用户组图标">
                                <div class="image-preview" v-if="form.avatar">
                                    <img :src="form.avatar">
                                    <icon type="close" @click.native="removeAvatar"></icon>
                                </div>
                                <upload :action="action"
                                        :before-upload="uploadBefore"
                                        :format="['jpg','jpeg','png']"
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
                            <form-item label="用户组说明" prop="description">
                                <i-input :autosize="{minRows: 5,maxRows: 9}"
                                         placeholder="请输入用户组说明"
                                         type="textarea"
                                         v-model="form.description"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="添加用户" prop="users">
                                <i-input :autosize="{minRows: 5,maxRows: 9}"
                                         placeholder="请输入用户列表，每行一个"
                                         type="textarea"
                                         v-model="form.users"></i-input>
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
