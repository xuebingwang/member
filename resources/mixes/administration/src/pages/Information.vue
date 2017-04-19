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
                        key: 'name',
                        title: '信息名称',
                        width: 100,
                    },
                    {
                        key: 'order',
                        render(row, column, index) {
                            return `<i-input v-model="list[${index}].order"></i-input>`;
                        },
                        title: '显示顺序',
                        width: 90,
                    },
                    {
                        align: 'center',
                        key: 'register',
                        render(row, column, index) {
                            return `<checkbox v-model="list[${index}].register"></checkbox>`;
                        },
                        title: '注册是否显示',
                        width: 110,
                    },
                    {
                        align: 'center',
                        key: 'detail',
                        render(row, column, index) {
                            return `<checkbox v-model="list[${index}].detail"></checkbox>`;
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
                        width: 100,
                    },
                    {
                        key: 'none',
                        title: ' ',
                    },
                    {
                        align: 'center',
                        key: 'handle',
                        render(row) {
                            return `<i-button size="small" type="default" @click.native="edit(${row.id})">编辑</i-button>`;
                        },
                        title: '操作',
                        width: 150,
                    },
                ],
                list: [
                    {
                        description: '',
                        detail: false,
                        groups: [],
                        id: 1,
                        name: '真实姓名',
                        order: '1',
                        privacy: '',
                        register: false,
                        required: false,
                        type: 'input',
                    },
                    {
                        description: '',
                        detail: false,
                        groups: [],
                        id: 2,
                        name: '昵称',
                        order: '1',
                        privacy: '',
                        register: false,
                        required: false,
                        type: 'input',
                    },
                    {
                        description: '',
                        detail: false,
                        groups: [],
                        id: 3,
                        name: '自我介绍',
                        order: '1',
                        privacy: '',
                        register: false,
                        required: false,
                        type: 'input',
                    },
                ],
                self: this,
            };
        },
        methods: {
            edit(id) {
                this.$router.push(`/member/information/${id}/edit`);
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
                <i-form :label-width="0" :model="form" ref="form" :rules="rules">
                    <i-table :columns="columns" :context="self" :data="list"></i-table>
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
