<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/user/list`, {
                format: 'beauty',
                with: [
                    'ban',
                    'groups',
                    'groups.details',
                ],
            }).then(response => {
                next(vm => {
                    vm.users = response.data.data;
                    injection.loading.finish();
                    injection.sidebar.active('member');
                });
            }).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            return {
                columns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'name',
                        title: injection.trans('member.user.table.title'),
                        width: 100,
                    },
                    {
                        key: 'email',
                        title: injection.trans('member.user.table.email'),
                        width: 240,
                    },
                    {
                        key: 'group',
                        title: injection.trans('member.user.table.group'),
                        width: 100,
                    },
                    {
                        key: 'created_at',
                        title: injection.trans('member.user.table.date'),
                    },
                ],
                form: {
                    content: '',
                    title: '',
                    users: [],
                    way: 'system',
                },
                rules: {
                    content: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入通知内容',
                            trigger: 'change',
                        },
                    ],
                    title: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入通知标题',
                            trigger: 'change',
                        },
                    ],
                    users: [
                        {
                            required: true,
                            type: 'array',
                            message: '请选择用户',
                            trigger: 'change',
                        },
                    ],
                    way: [
                        {
                            required: true,
                            type: 'string',
                            message: '请选择发送方式',
                            trigger: 'change',
                        },
                    ],
                },
                self: this,
                status: 'wait',
                step: 0,
                users: [],
                ways: [
                    {
                        label: 'system',
                        text: '系统消息',
                    },
//                    {
//                        label: 'wechat',
//                        text: '微信',
//                    },
//                    {
//                        label: 'message',
//                        text: '手机短信',
//                    },
//                    {
//                        label: 'email',
//                        text: '电子邮件',
//                    },
                ],
            };
        },
        methods: {
            selection(val) {
                const self = this;
                self.form.users = [];
                val.forEach(item => {
                    self.form.users.push(item.id);
                });
            },
            submit() {
                const self = this;
                self.loading = true;
                self.$refs.form.validate(valid => {
                    window.console.log(valid);
                    if (valid) {
                        if (self.step < 2) {
                            self.loading = false;
                            self.step += 1;
                        } else {
                            self.$loading.start();
                            self.$http.post(`${window.api}/member/notification/send`, self.form).then(() => {
                                self.$loading.finish();
                                self.$notice.open({
                                    title: '群发消息成功！',
                                });
                                self.$router.push('/member/notification');
                            }).catch(() => {
                                self.$loading.error();
                            }).finally(() => {
                                self.loading = false;
                            });
                        }
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请先填写完整信息！',
                        });
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="member-wrap">
        <div class="user-notification">
            <card>
                <template slot="title">
                    <span class="text">发送通知</span>
                </template>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="18">
                            <div v-if="step === 0">
                                <form-item label="发送方式" prop="way">
                                    <radio-group v-model="form.way" vertical>
                                        <radio :label="way.label" v-for="way in ways">
                                            <span>{{ way.text }}</span>
                                        </radio>
                                    </radio-group>
                                </form-item>
                            </div>
                            <div v-if="step === 1">
                                <form-item label="筛选用户" prop="users">
                                    <i-table :columns="columns" :context="self" :data="users" @on-selection-change="selection"></i-table>
                                </form-item>
                            </div>
                            <div v-if="step === 2">
                                <row>
                                    <i-col span="16">
                                        <form-item label="通知标题" prop="title">
                                            <i-input placeholder="请输入通知标题" v-model="form.title"></i-input>
                                        </form-item>
                                    </i-col>
                                    <i-col span="16">
                                        <form-item label="通知内容" prop="content">
                                            <i-input :autosize="{minRows: 5,maxRows: 10}"
                                                     placeholder="请输入通知内容"
                                                     type="textarea"
                                                     v-model="form.content"></i-input>
                                        </form-item>
                                    </i-col>
                                </row>
                            </div>
                            <form-item>
                                <i-button :loading="loading" type="primary" @click.native="submit">
                                    <span v-if="!loading">下一步</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </i-col>
                        <i-col span="6">
                            <steps :current="step" direction="vertical" :status="status">
                                <step title="第一步" content="选取发送方式"></step>
                                <step title="第二步" content="筛选用户"></step>
                                <step title="第三步" content="填写通知内容"></step>
                            </steps>
                        </i-col>
                    </row>
                </i-form>
            </card>
        </div>
    </div>
</template>