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
                form: {
                    from: '管理员组',
                    remove: false,
                    to: '',
                },
                groups: [
                    {
                        label: '普通组',
                        value: 'normal',
                    },
                ],
                removeable: [
                    {
                        label: true,
                        text: '是',
                    },
                    {
                        label: false,
                        text: '否',
                    },
                ],
                loading: false,
            };
        },
        methods: {
            submit() {
            },
        },
        mounted() {
            this.$store.commit('title', injection.trans('administration.title.setting'));
        },
        watch: {
            form: {
                deep: true,
                handler(val) {
                    window.console.log(typeof val.remove);
                },
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="group-create">
            <card>
                <p slot="title">合并用户组</p>
                <div class="extend-info">
                    <p>提示</p>
                    <p>用户组合并可将源用户组的用户合并进入所选的新用户组，并且可以选择删除源用户组。</p>
                    <p>用户组合并不可以操作管理组。</p>
                    <p>用户组合并一旦提交立即生效，并无法恢复，请仔细选择目标用户组和设置项目。</p>
                </div>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="10">
                            <form-item label="用户组名称">
                                <p>{{ form.from }}</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="10">
                            <form-item label="目标用户组">
                                <i-select v-model="form.to">
                                    <i-option :key="item" :value="item.value" v-for="item in groups">{{ item.label }}</i-option>
                                </i-select>
                                <p>选择要将源用户组合并到哪个用户组</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="10">
                            <form-item label="同时删除源用户组" prop="users">
                                <radio-group v-model="form.remove">
                                    <radio :label="item.label" v-for="item in removeable">
                                        <span>{{ item.text }}</span>
                                    </radio>
                                </radio-group>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="10">
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
