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
                    tag: '',
                    users: '',
                },
                loading: false,
                rules: {
                    tag: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入标签名称',
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
                        self.$http.post(`${window.api}/member/tag/create`, self.form).then(() => {
                            self.$loading.finish();
                            self.$notice.open({
                                title: '创建标签成功！',
                            });
                            self.$router.push('/member/tag');
                        }).catch(() => {
                            self.$loading.error();
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.$notice.error({
                            title: '请正确填写标签信息',
                        });
                        self.loading = false;
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
            <card :bordered="false">
                <p slot="title">添加标签</p>
                <div class="extend-info">
                    <p>提示</p>
                    <p>可以给线下活动的用户批量贴标签。</p>
                    <p>当只填写了标签，用户列表为空时，是批量添加用户标签。</p>
                    <p>如果标签和用户列表都有输入，说明是给指定用户批量贴标签。</p>
                </div>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="12">
                            <form-item label="标签名称" prop="tag">
                                <i-input placeholder="请输入标签名称" v-model="form.tag"></i-input>
                                <p>可以输入多个标签，多个标签可以用<strong>逗号分隔(,)</strong>。</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="添加用户" prop="users">
                                <i-input :autosize="{minRows: 5,maxRows: 9}"
                                         placeholder="请输入用户列表，每行一个"
                                         type="textarea"
                                         v-model="form.users"></i-input>
                                <p class="info">可以输入多个用户，每行输入一个用户名。</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
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