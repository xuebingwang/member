<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/groups/index`).then(response => {
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
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'avatar',
                        render(row) {
                            if (row.avatar) {
                                return `<img class="group-list-image" src="${row.avatar}">`;
                            }
                            return '';
                        },
                        title: injection.trans('用户组图标'),
                        width: 100,
                    },
                    {
                        key: 'name',
                        title: injection.trans('用户组名称'),
                        width: 100,
                    },
                    {
                        key: 'status',
                        title: injection.trans('当前已有模块'),
                        width: 120,
                    },
                    {
                        key: 'group',
                        title: injection.trans('已有用户数'),
                        width: 100,
                    },
                    {
                        key: 'created_at',
                        title: injection.trans('创建时间'),
                    },
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `
                                    <i-button size="small" type="default" @click.native="edit(${row.id})">合并用户组</i-button>
                                    <i-button size="small" type="default" @click.native="edit(${row.id})">编辑用户组</i-button>
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
                groups: [],
                keyword: '',
                list: [],
                pagination: {
                    last_page: 1,
                },
                selections: [],
                self: this,
                trans: injection.trans,
            };
        },
        methods: {
            edit(id) {
                this.$router.push(`/member/group/${id}/edit`);
            },
            selection(items) {
                this.selections = items;
            },
        },
        mounted() {
            this.$store.commit('title', '用户组管理 - 用户中心');
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="group-list">
            <card>
                <template slot="title">
                    <span class="text">用户组列表</span>
                    <router-link class="extend" to="/member/group/create">
                        <i-button type="default">添加用户组</i-button>
                    </router-link>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
            </card>
        </div>
    </div>
</template>
