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
                    ],
                }),
            ]).then(injection.http.spread((groups, user) => {
                window.console.log(groups, user);
                next(vm => {
                    vm.groups = groups.data.data;
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
                    group: '',
                    reason: '',
                },
                groups: [],
                loading: false,
                rules: {},
            };
        },
        methods: {
            dateChange(val) {
                this.form.date = val;
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
                            <form-item label="所属用户组">
                                <i-select v-model="form.group">
                                    <i-option v-for="item in groups" :value="item.value" :key="item">{{ item.label }}</i-option>
                                </i-select>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="用户组有效期">
                                <date-picker :placeholder="请选择用户组有效期"
                                             type="date"
                                             :value="form.date"
                                             @on-change="dateChange">
                                </date-picker>
                                <p>如需设定当前用户组的有效期，请输入用户组截止日期，留空为不做过期限制。</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="过期后用户组变为">
                                <i-select v-model="form.group">
                                    <i-option v-for="item in groups" :value="item.value" :key="item">{{ item.label }}</i-option>
                                </i-select>
                            </form-item>
                        </i-col>
                    </row>
                    <p class="extend-title">扩展用户组</p>
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
