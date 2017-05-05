<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/information/group/list`).then(response => {
                const data = response.data.data;
                const pagination = response.data.pagination;
                next(vm => {
                    data.forEach(item => {
                        item.loading = false;
                    });
                    vm.groups = data;
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
                        align: 'center',
                        key: 'show',
                        render(row, column, index) {
                            return `<checkbox v-model="groups[${index}].show"></checkbox>`;
                        },
                        title: '显示',
                        width: 100,
                    },
                    {
                        key: 'order',
                        render(row, column, index) {
                            return `<i-input v-model="groups[${index}].order"></i-input>`;
                        },
                        title: '显示顺序',
                        width: 200,
                    },
                    {
                        key: 'name',
                        title: '栏目分组名称',
                    },
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `
                                    <i-button size="small" type="default" @click.native="edit(${row.id})">编辑</i-button>
                                    <i-button :loading="groups[${index}].loading" size="small" type="error" @click.native="remove(${index})">
                                        <span v-if="!groups[${index}].loading">删除</span>
                                        <span v-else>正在删除...</span>
                                    </i-button>
                                    `;
                        },
                        title: '操作',
                        width: 300,
                    },
                ],
                groups: [],
                loading: false,
                pagination: {},
                self: this,
            };
        },
        methods: {
            edit(id) {
                this.$router.push(`/member/information/group/${id}/edit`);
            },
            remove(index) {
                const self = this;
                const group = self.groups[index];
                group.loading = true;
                self.$http.post(`${window.api}/member/information/group/remove`, {
                    id: group.id,
                }).then(() => {
                    self.$loading.finish();
                    self.$notice.open({
                        title: '删除信息分组成功！',
                    });
                    self.$notice.open({
                        title: '正在刷新数据...',
                    });
                    self.$loading.start();
                    self.$http.post(`${window.api}/member/information/group/list`).then(response => {
                        const data = response.data.data;
                        const pagination = response.data.pagination;
                        data.forEach(item => {
                            item.loading = false;
                        });
                        self.$loading.finish();
                        self.$notice.open({
                            title: '刷新数据成功！',
                        });
                        self.groups = data;
                        self.pagination = pagination;
                    }).catch(() => {
                        self.$loading.error();
                    });
                }).finally(() => {
                    group.loading = false;
                });
            },
            submit() {
                const self = this;
                self.loading = true;
                self.$http.post(`${window.api}/member/information/group/patch`, {
                    data: self.groups,
                }).then(() => {
                    self.$notice.open({
                        title: '批量更新数据成功！',
                    });
                    self.$notice.open({
                        title: '正在刷新数据...',
                    });
                    self.$loading.start();
                    self.$http.post(`${window.api}/member/information/group/list`).then(response => {
                        const data = response.data.data;
                        const pagination = response.data.pagination;
                        data.forEach(item => {
                            item.loading = false;
                        });
                        self.$loading.finish();
                        self.$notice.open({
                            title: '刷新数据成功！',
                        });
                        self.groups = data;
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
            <card>
                <template slot="title">
                    <span class="text">信息分组</span>
                    <router-link class="extend" to="/member/information/group/create">
                        <i-button type="default">添加信息分组</i-button>
                    </router-link>
                </template>
                <div class="extend-info">
                    <p>提示</p>
                    <p>用户栏目分组至少必须启用一项，如果都不启用，默认为全部启用。</p>
                </div>
                <i-form :label-width="0" :model="form" ref="form" :rules="rules">
                    <i-table :columns="columns" :context="self" :data="groups"></i-table>
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