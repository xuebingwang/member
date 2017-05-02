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
                    end: '',
                    ip: '',
                    reason: '',
                },
                loading: false,
                rules: {
                    ip: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入封禁 IP',
                            trigger: 'change',
                        },
                        {
                            required: true,
                            pattern: /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/,
                            message: '请输入正确的封禁 IP 地址',
                            trigger: 'change',
                        },
                    ],
                },
            };
        },
        methods: {
            submit() {
                const self = this;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        self.loading = true;
                        window.console.log(self.form);
                        self.$http.post(`${window.api}/member/ban/create`, self.form).then(() => {
                            self.$notice.open({
                                title: '添加封禁 IP 成功！',
                            });
                            self.$router.push('/member/ban/ip');
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
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-ban">
            <card>
                <template slot="title">
                    <span class="text">封禁 IP</span>
                </template>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="12">
                            <form-item label="封禁 IP" prop="ip">
                                <i-input placeholder="请输入封禁 IP" v-model="form.ip"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="8">
                            <form-item label="封禁时间">
                                <date-picker :placeholder="请选择封禁截止时间"
                                             type="date"
                                             v-model="form.end">
                                </date-picker>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="封禁 IP 的理由" prop="reason">
                                <i-input :autosize="{minRows: 5,maxRows: 9}"
                                         placeholder="请输入封禁 IP 的理由"
                                         type="textarea"
                                         v-model="form.reason"></i-input>
                                <p class="info">请输入操作理由，系统将把理由记录在用户禁止记录中，以供日后查看。</p>
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