<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/information/list`).then(response => {
                const data = response.data.data;
                const pagination = response.data.pagination;
                next(vm => {
                    data.forEach(item => {
                        item.loading = false;
                    });
                    vm.list = data;
                    vm.pagination = pagination;
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
                        key: 'name',
                        title: '信息项名称',
                        width: 300,
                    },
                    {
                        align: 'center',
                        key: 'order',
                        render(row, column, index) {
                            return `<i-input v-model="list[${index}].order"></i-input>`;
                        },
                        title: '显示顺序',
                        width: 120,
                    },
                    {
                        align: 'center',
                        key: 'register',
                        render(row, column, index) {
                            return `<checkbox v-model="list[${index}].register"></checkbox>`;
                        },
                        title: '注册是否显示',
                        width: 120,
                    },
                    {
                        align: 'center',
                        key: 'details',
                        render(row, column, index) {
                            return `<checkbox v-model="list[${index}].details"></checkbox>`;
                        },
                        title: '资料页是否显示',
                        width: 120,
                    },
                    {
                        align: 'center',
                        key: 'required',
                        render(row, column, index) {
                            return `<checkbox v-model="list[${index}].required"></checkbox>`;
                        },
                        title: '是否必填',
                        width: 120,
                    },
                    {
                        key: 'none',
                        title: ' ',
                    },
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `
                                    <i-button size="small" type="default" @click.native="edit(${row.id})">编辑</i-button>
                                    <i-button :loading="list[${index}].loading" size="small" type="error" @click.native="remove(${index})">
                                        <span v-if="!list[${index}].loading">删除</span>
                                        <span v-else>正在删除...</span>
                                    </i-button>
                                    `;
                        },
                        title: '操作',
                        width: 300,
                    },
                ],
                list: [],
                loading: false,
                pagination: {},
                self: this,
            };
        },
        methods: {
            edit(id) {
                this.$router.push(`/member/information/${id}/edit`);
            },
            remove(index) {
                const self = this;
                const information = self.list[index];
                information.loading = true;
                self.$http.post(`${window.api}/member/information/remove`, {
                    id: information.id,
                }).then(() => {
                    self.$notice.open({
                        title: '删除信息项成功！',
                    });
                    self.$notice.open({
                        title: '正在刷新数据...',
                    });
                    self.$loading.start();
                    self.$http.post(`${window.api}/member/information/list`).then(response => {
                        const data = response.data.data;
                        const pagination = response.data.pagination;
                        data.forEach(item => {
                            item.loading = false;
                        });
                        self.$loading.finish();
                        self.$notice.open({
                            title: '刷新数据完成！',
                        });
                        self.list = data;
                        self.pagination = pagination;
                    }).catch(() => {
                        self.$loading.error();
                    });
                }).finally(() => {
                    information.loading = false;
                });
            },
            submit() {
                const self = this;
                self.loading = true;
                self.$http.post(`${window.api}/member/information/patch`, {
                    data: self.list,
                }).then(() => {
                    self.$notice.open({
                        title: '批量更新信息项数据成功！',
                    });
                    self.$notice.open({
                        title: '正在更新信息项数据...',
                    });
                    self.$loading.start();
                    self.$http.post(`${window.api}/member/information/list`).then(response => {
                        const data = response.data.data;
                        const pagination = response.data.pagination;
                        data.forEach(item => {
                            item.loading = false;
                        });
                        self.$loading.finish();
                        self.$notice.open({
                            title: '更新信息项数据完成！',
                        });
                        self.list = data;
                        self.pagination = pagination;
                    }).catch(() => {
                        self.$loading.error();
                    });
                }).finally(() => {
                    self.loading = false;
                });
            },
        },
    };
</script>
<template>
    <div class="member-wrap">
        <div class="user-information">
            <card :bordered="false">
                <template slot="title">
                    <span class="text">信息列表</span>
                    <router-link class="extend" to="/member/information/create">
                        <i-button type="default">添加信息分组</i-button>
                    </router-link>
                </template>
                <i-form :label-width="0" :model="form" ref="form" :rules="rules">
                    <i-table :columns="columns" :context="self" :data="list"></i-table>
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