<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/tag/list`).then(response => {
                window.console.log(response);
                next(vm => {
                    vm.list = response.data.data;
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
                        type: 'selection',
                        width: 100,
                    },
                    {
                        key: 'tag',
                        title: injection.trans('标签名称'),
                        width: 200,
                    },
                    {
                        key: 'users',
                        title: injection.trans('用户数'),
                    },
                    {
                        key: 'created_at',
                        title: injection.trans('创建时间'),
                    },
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `
                                    <i-button size="small" type="default" @click.native="notification(${row.id})">发送通知</i-button>
                                    <i-button size="small" type="default" @click.native="list(${row.id})">用户列表</i-button>
                                    <i-button :loading="list[${index}].loading"  size="small" type="error" @click.native="remove(${index})">
                                        <span v-if="!list[${index}].loading">${injection.trans('content.global.delete.submit')}</span>
                                        <span v-else>${injection.trans('content.global.delete.loading')}</span>
                                    </i-button>
                                    `;
                        },
                        title: injection.trans('member.user.table.handle'),
                        width: 300,
                    },
                ],
                form: {
                    tags: [],
                    target: '',
                    type: 'delete',
                },
                types: [
                    {
                        label: 'delete',
                        text: '删除',
                    },
                    {
                        label: 'combine',
                        text: '合并到',
                    },
                ],
                list: [],
                loading: false,
                self: this,
            };
        },
        methods: {
            selection(items) {
                const self = this;
                self.form.tags = [];
                items.forEach(item => {
                    self.form.tags.push(item.id);
                });
            },
            submit() {
                const self = this;
                self.loading = true;
                if (!self.form.tags.length) {
                    self.$notice.error({
                        title: '请先选择标签！',
                    });
                    self.loading = false;
                }
                if (self.form.type === 'combine' && self.form.target === '') {
                    self.$notice.error({
                        title: '请输入合并到的标签名称！',
                    });
                    self.loading = false;
                } else {
                    self.$http.post(`${window.api}/member/tag/patch`, self.form).then(() => {
                        self.$notice.open({
                            title: '批量更新标签数据成功！',
                        });
                        self.$notice.open({
                            title: '准备更新标签数据...',
                        });
                        self.$loading.start();
                        self.$http.post(`${window.api}/member/tag/list`).then(response => {
                            self.list = response.data.data;
                            self.$loading.finish();
                        }).catch(() => {
                            self.$loading.error();
                        });
                    }).finally(() => {
                        self.loading = false;
                    });
                }
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-tag">
            <card>
                <template slot="title">
                    <span class="text">用户标签</span>
                    <router-link class="extend" to="/member/tag/create">
                        <i-button type="default">添加用户标签</i-button>
                    </router-link>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
                <i-form :label-width="0" :model="form">
                    <row>
                        <i-col span="24">
                            <form-item label="批量操作">
                                <radio-group v-model="form.type">
                                    <radio :label="item.label" v-for="item in types">
                                        <span>{{ item.text }}</span>
                                    </radio>
                                </radio-group>
                                <i-input placeholder="请输入标签名称"
                                         size="small"
                                         v-if="form.type === 'combine'"
                                         v-model="form.target">
                                </i-input>
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