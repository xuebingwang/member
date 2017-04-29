<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('member');
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
                        key: 'name',
                        title: injection.trans('标签名称'),
                        width: 200,
                    },
                    {
                        key: 'name',
                        title: injection.trans('用户数'),
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
                form: {
                    tags: [],
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
            selection() {
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
                                         v-model="form.description">
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