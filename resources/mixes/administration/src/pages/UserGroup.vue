<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.all([
                injection.http.post(`${window.api}/member/group/list`),
                injection.http.post(`${window.api}/member/user`, {
                    id: to.params.id,
                    with: [
                        'group',
                    ],
                }),
            ]).then(injection.http.spread((groups, user) => {
                const data = groups.data.data;
                const group = user.data.data.group;
                let extend = null;
                if (group && group.extends) {
                    extend = JSON.parse(group.extends);
                }
                next(vm => {
                    data.forEach(item => {
                        if (extend) {
                            extend.map(has => {
                                if (has.group === item.id) {
                                    item.check = true;
                                    item.end = has.end;
                                }
                                return item;
                            });
                        }
                        item.check = item.check ? item.check : false;
                        item.end = item.end ? item.end : '';
                    });
                    vm.form.id = user.data.data.id;
                    vm.groups = groups.data.data;
                    if (group) {
                        vm.form.date = group.end;
                        vm.form.group = group.group_id;
                    }
                    injection.loading.finish();
                    injection.sidebar.active('member');
                });
            })).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            return {
                form: {
                    date: '',
                    group: 0,
                    id: 0,
                    next: 0,
                    reason: '',
                },
                groups: [],
                loading: false,
                rules: {
                    group: [
                        {
                            required: true,
                            type: 'number',
                            message: '请选择所属用户组',
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
                        self.form.groups = self.groups;
                        self.$http.post(`${window.api}/member/user/group`, self.form).then(response => {
                            self.$notice.open({
                                title: response.data.message,
                            });
                            self.$router.push('/member/user');
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.$notice.error({
                            title: '请正确填写用户组信息',
                        });
                        self.loading = false;
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-create">
            <card>
                <p slot="title">编辑用户组</p>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <p class="extend-title">用户组</p>
                    <row>
                        <i-col span="14">
                            <form-item label="所属用户组" prop="group">
                                <i-select v-model="form.group">
                                    <i-option v-for="item in groups" :value="item.id" :key="item">{{ item.name }}</i-option>
                                </i-select>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="用户组有效期">
                                <date-picker :placeholder="请选择用户组有效期"
                                             type="date"
                                             v-model="form.date">
                                </date-picker>
                                <p>如需设定当前用户组的有效期，请输入用户组截止日期，留空为不做过期限制。</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="过期后用户组变为">
                                <i-select v-model="form.next">
                                    <i-option v-for="item in groups" :value="item.id" :key="item" v-if="item.id !== form.group">{{ item.name }}</i-option>
                                </i-select>
                            </form-item>
                        </i-col>
                    </row>
                    <p class="extend-title">扩展用户组</p>
                    <div class="user-group-extend">
                        <row>
                            <i-col span="6">用户组</i-col>
                            <i-col span="4">有效期</i-col>
                        </row>
                        <row v-for="item in groups" v-if="item.id !== form.group">
                            <i-col span="6">
                                <checkbox v-model="item.check">{{ item.name }}</checkbox>
                            </i-col>
                            <i-col span="4">
                                <date-picker placeholder="请选择用户组有效期"
                                             type="date"
                                             v-model="item.end">
                                </date-picker>
                            </i-col>
                        </row>
                        <p>注意: 有效期格式 yyyy-mm-dd，如果留空，则默认该扩展用户组不自动过期</p>
                    </div>
                    <p class="extend-title">变更理由</p>
                    <row>
                        <i-col span="14">
                            <form-item label="变更用户组的理由" prop="users">
                                <i-input :autosize="{minRows: 5,maxRows: 9}"
                                         placeholder="请输入变更用户组的理由"
                                         type="textarea"
                                         v-model="form.reason">
                                </i-input>
                                <p class="info">如果您通过用户组设定禁止或解除禁止该用户，请输入操作理由，系统将把理由记录在用户禁止记录中，以供日后查看。</p>
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
