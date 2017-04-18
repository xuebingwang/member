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
                                    <i-button size="small" type="default" @click.native="group(${index})">用户组</i-button>
                                    <i-button size="small" type="default" @click.native="integral(${index})">积分</i-button>
                                    <i-button size="small" type="default" @click.native="edit(${index})">详情</i-button>
                                    <i-button size="small" type="default" @click.native="ban(${index})">封禁</i-button>
                                    <i-button size="small" type="error" @click.native="remove(${index})">删除</i-button>
                                    `;
                        },
                        title: injection.trans('member.user.table.handle'),
                        width: 300,
                    },
                ],
                groups: [],
                keyword: '',
                list: [],
                modal: {
                    loading: true,
                    visible: false,
                },
                pagination: {
                    last_page: 1,
                },
                selections: [],
                self: this,
                trans: injection.trans,
                user: {},
            };
        },
        methods: {
            ban(index) {
                const self = this;
                const user = self.list[index];
                self.$router.push(`/member/user/${user.id}/ban`);
            },
            edit(index) {
                const self = this;
                const user = self.list[index];
                self.$router.push(`/member/user/${user.id}/edit`);
            },
            group(index) {
                const self = this;
                const user = self.list[index];
                self.$router.push(`/member/user/${user.id}/group`);
            },
            integral(index) {
                const self = this;
                const user = self.list[index];
                self.$router.push(`/member/user/${user.id}/integral`);
            },
            output() {
                window.console.log('Output done!');
            },
            remove(index) {
                this.user = this.list[index];
                this.modal.visible = true;
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
        <div class="user-list">
            <card>
                <template slot="title">
                    <router-link to="/member/user/create">
                        <i-button type="default">添加用户
                        </i-button>
                    </router-link>
                    <i-button type="default" @click.native="output">导出数据</i-button>
                    <i-input class="search" :placeholder="trans('content.global.search.placeholder')" v-model="keyword">
                        <i-select v-model="select3" slot="prepend" style="width: 80px">
                            <Option value="day">日活</Option>
                            <Option value="month">月活</Option>
                        </i-select>
                        <i-button slot="append" icon="ios-search" @click.native="search"></i-button>
                    </i-input>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
                <modal class-name="user-list-modal"
                       :loading="modal.loading"
                       :mask-closable="false"
                       title="删除用户"
                       :value="modal.visible"
                       :width="772"
                       @on-cancel="modal.visible = false"
                       @on-ok="remove">
                    <p>本操作不可恢复，您确定要删除用户 <strong>{{ user.name }}</strong> 吗？</p>
                    <i-form label-position="right" :label-width="148" :model="user" ref="form">
                        <form-item label="删除用户的理由">
                            <i-input type="textarea" placeholder="请输入删除用户的理由" v-model="user.reason"
                                     :autosize="{minRows: 5,maxRows: 9}"></i-input>
                            <p class="info">请输入操作理由，系统将把理由记录在用户删除记录中，以供日后查看。</p>
                        </form-item>
                    </i-form>
                </modal>
            </card>
        </div>
    </div>
</template>
