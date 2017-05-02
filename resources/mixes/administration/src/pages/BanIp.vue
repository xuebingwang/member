<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/ban/ip`).then(response => {
                window.console.log(response);
                const list = response.data.data;
                const pagination = response.data.pagination;
                next(vm => {
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
                        key: 'avatar',
                        render(row) {
                            if (row.avatar) {
                                return `<img class="user-list-image" src="${row.avatar}">`;
                            }
                            return '';
                        },
                        title: injection.trans('member.user.table.avatar'),
                        width: 66,
                    },
                    {
                        key: 'name',
                        title: injection.trans('member.user.table.title'),
                        width: 100,
                    },
                    {
                        key: 'status',
                        title: injection.trans('member.user.table.status'),
                        width: 100,
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
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `
                                    <i-button size="small" type="default" @click.native="group(${row.id})">用户组</i-button>
                                    <i-button size="small" type="default" @click.native="integral(${row.id})">积分</i-button>
                                    <i-button size="small" type="default" @click.native="edit(${row.id})">编辑详情</i-button>
                                    <i-button size="small" type="default" @click.native="ban(${row.id})">封禁</i-button>
                                    <i-button size="small" type="error" @click.native="remove(${index})">删除</i-button>
                                    `;
                        },
                        title: injection.trans('member.user.table.handle'),
                        width: 300,
                    },
                ],
                list: [],
                pagination: {},
            };
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-ban">
            <card>
                <template slot="title">
                    <span class="text">封禁 IP</span>
                    <div class="search">
                        <router-link to="/member/ban/ip/create">
                            <i-button type="default">添加封禁 IP</i-button>
                        </router-link>
                    </div>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
            </card>
        </div>
    </div>
</template>