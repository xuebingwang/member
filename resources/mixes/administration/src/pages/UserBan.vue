<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/members/${to.params.id}/show`).then(response => {
                const data = response.data.data;
                next(vm => {
                    vm.form.id = data.id;
                    vm.form.name = data.name;
                    injection.loading.finish();
                    injection.sidebar.active('member');
                });
            }).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            return {
                form: {
                    id: '',
                    name: '',
                    reason: '',
                    status: '',
                    type: '',
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
        <div class="user-ban">
            <card>
                <p slot="title">封禁用户</p>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="14">
                            <form-item label="禁止用户名" prop="name">
                                <i-input placeholder="请输入禁止用户名" v-model="form.name"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="当前状态" prop="name">
                                <span>正常状态</span>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="禁止类型" prop="name">
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="禁止/解禁用户的理由" prop="users">
                                <i-input :autosize="{minRows: 5,maxRows: 9}"
                                         placeholder="请输入禁止/解禁用户的理由"
                                         type="textarea"
                                         v-model="form.users"></i-input>
                                <p class="info">请输入操作理由，系统将把理由记录在用户禁止记录中，以供日后查看。</p>
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
