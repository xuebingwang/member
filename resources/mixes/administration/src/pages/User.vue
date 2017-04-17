<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/members/index`).then(response => {
                next(vm => {
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
                        key: 'title',
                        title: injection.trans('member.user.table.title'),
                    },
                    {
                        key: 'created_at',
                        title: injection.trans('member.user.table.date'),
                        width: 200,
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
    <div class="article-wrap">
        <div class="article-list">
            <card>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
            </card>
        </div>
    </div>
</template>
