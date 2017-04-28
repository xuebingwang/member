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
                        'groups',
                        'groups.details',
                    ],
                }),
            ]).then(injection.http.spread((groups, user) => {
                const data = groups.data.data;
                const group = user.data.data.groups;
                next(vm => {
                    data.forEach(item => {
                        if (group) {
                            group.map(has => {
                                if (has.type === 'default') {
                                    vm.form.date = has.end;
                                    vm.form.group = has.group_id;
                                    vm.form.next = has.next;
                                } else if (has.group_id === item.id) {
                                    item.check = true;
                                    item.end = has.end;
                                }
                                return has;
                            });
                        }
                        item.check = item.check ? item.check : false;
                        item.end = item.end ? item.end : '';
                    });
                    if (vm.form.group === 0) {
                        vm.form.group = data[0].id;
                    }
                    vm.form.id = user.data.data.id;
                    vm.groups = data;
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
                const groups = [];
                const self = this;
                const id = self.$route.params.id;
                self.loading = true;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        groups.push({
                            end: self.form.date,
                            group_id: self.form.group,
                            member_id: id,
                            next: self.form.next,
                            reason: self.form.reason,
                            type: 'default',
                        });
                        self.groups.map(group => {
                            if (group.check) {
                                groups.push({
                                    end: group.end,
                                    group_id: group.id,
                                    member_id: id,
                                    next: 0,
                                    reason: '',
                                    type: 'extend',
                                });
                            }
                            return group;
                        });
                        console.log(groups);
                        self.$http.post(`${window.api}/member/user/group`, {
                            data: groups,
                            member_id: id,
                        }).then(response => {
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
