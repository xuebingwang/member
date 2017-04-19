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
                        render(row) {
                            return `<i-button size="small" type="default" @click.native="edit(${row.id})">编辑</i-button>`;
                        },
                        title: '操作',
                        width: 150,
                    },
                ],
                groups: [
                    {
                        show: false,
                        order: '1',
                        name: '特别信息',
                    },
                    {
                        show: true,
                        order: '1',
                        name: '特别信息',
                    },
                    {
                        show: false,
                        order: '1',
                        name: '没有信息',
                    },
                    {
                        show: true,
                        order: '1',
                        name: '特别信息',
                    },
                    {
                        show: false,
                        order: '1',
                        name: '固定信息',
                    },
                ],
                self: this,
            };
        },
        methods: {
            showChange(checked, index) {
                window.console.log(checked, index);
            },
        },
        watch: {
            groups: {
                deep: true,
                handler(val) {
                    window.console.log(val);
                },
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
                    <router-link class="extend" to="/member/information/create">
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
                        <i-col span="14">
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
