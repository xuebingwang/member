<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/ban/ip`).then(response => {
                const list = response.data.data;
                const pagination = response.data.pagination;
                next(vm => {
                    list.forEach(item => {
                        item.loading = false;
                    });
                    vm.list = list;
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
                        key: 'ip',
                        title: injection.trans('IP 地址'),
                        width: 300,
                    },
                    {
                        key: 'end',
                        title: injection.trans('封禁截止时间'),
                        width: 200,
                    },
                    {
                        key: 'reason',
                        title: injection.trans('封禁原因'),
                    },
                    {
                        key: 'created_at',
                        title: injection.trans('操作时间'),
                        width: 200,
                    },
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `<i-button :loading="list[${index}].loading" size="small" type="error" @click.native="remove(${index})">
                                        <span v-if="!list[${index}].loading">删除 IP</span>
                                        <span v-else>正在删除 IP…</span>
                                    </i-button>`;
                        },
                        title: injection.trans('操作'),
                        width: 300,
                    },
                ],
                list: [],
                pagination: {},
                self: this,
            };
        },
        methods: {
            paginator(page) {
                const self = this;
                if (page < 1) {
                    self.$notice.error({
                        title: '页码错误！',
                    });
                }
                self.$loading.start();
                self.$notice.open({
                    title: '正在更新数据',
                });
                self.$http.post(`${window.api}/member/ban/ip`).then(response => {
                    const list = response.data.data;
                    const pagination = response.data.pagination;
                    list.forEach(item => {
                        item.loading = false;
                    });
                    self.$loading.finish();
                    self.list = list;
                    self.pagination = pagination;
                }).catch(() => {
                    self.$loading.error();
                });
            },
            remove(index) {
                const self = this;
                const item = self.list[index];
                item.loading = true;
                self.$http.post(`${window.api}/member/ban/remove`, {
                    id: item.id,
                }).then(() => {
                    self.$notice.open({
                        title: '删除 IP 成功！',
                    });
                    self.paginator(1);
                }).catch(() => {
                    self.$notice.error({
                        title: '删除 IP 失败！',
                    });
                }).finally(() => {
                    item.loading = false;
                });
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-ban">
            <card :bordered="false">
                <template slot="title">
                    <span class="text">封禁 IP</span>
                    <div class="search">
                        <router-link to="/member/ban/ip/create">
                            <i-button type="default">添加封禁 IP</i-button>
                        </router-link>
                    </div>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
                <div class="user-page-wrap">
                    <page :current="pagination.current"
                          :page-size="pagination.paginate"
                          :total="pagination.total"
                          @on-change="paginator"></page>
                </div>
            </card>
        </div>
    </div>
</template>