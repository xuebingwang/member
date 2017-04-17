<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/members/index`).then(response => {
                next(vm => {
                    window.console.log(response.data.data);
                    vm.list = response.data.data;
                    injection.loading.finish();
                    injection.sidebar.active('member');
                });
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
                        title: injection.trans('member.user.table.avatar'),
                        width: 60,
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
                                    <i-button size="small" type="primary" @click.native="edit(${index})">${injection.trans('content.global.edit.submit')}</i-button>
                                    <i-button :loading="list[${index}].loading"  size="small" type="error" @click.native="remove(${index})">
                                        <span v-if="!list[${index}].loading">${injection.trans('content.global.delete.submit')}</span>
                                        <span v-else>${injection.trans('content.global.delete.loading')}</span>
                                    </i-button>
                                    `;
                        },
                        title: injection.trans('member.user.table.handle'),
                        width: 200,
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
            edit(index) {
                const self = this;
                const article = self.list[index];
                self.$router.push(`/member/user/${article.id}/edit`);
            },
            selection(items) {
                this.selections = items;
            },
        },
        mounted() {
            this.$store.commit('title', '用户管理 - 用户中心');
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="member-list">
            <card>
                <template slot="title">
                    <router-link to="/member/user/create">
                        <i-button type="default">添加用户
                        </i-button>
                    </router-link>
                    <i-button type="default">
                        <router-link to="/member/user/add">导出数据</router-link>
                    </i-button>
                    <i-input class="search" :placeholder="trans('content.global.search.placeholder')" v-model="keyword">
                        <i-select v-model="select3" slot="prepend" style="width: 80px">
                            <Option value="day">日活</Option>
                            <Option value="month">月活</Option>
                        </i-select>
                        <i-button slot="append" icon="ios-search" @click.native="search"></i-button>
                    </i-input>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
            </card>
        </div>
    </div>
</template>
