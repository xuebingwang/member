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
                    id: 1,
                    informations: [],
                    name: '特别信息',
                    order: '1',
                    show: false,
                },
                informations: [
                    {
                        label: '1',
                        text: '真实姓名',
                    },
                ],
            };
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-information-create">
            <card :bordered="false">
                <p slot="title">编辑信息分组</p>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="12">
                            <form-item label="分组名称" prop="name">
                                <i-input placeholder="请输入分组名称" v-model="form.name"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="前台显示">
                                <i-switch v-model="form.show" size="large">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                </i-switch>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="显示顺序">
                                <i-input placeholder="请输入显示顺序" v-model="form.order"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="用户资料分组">
                                <checkbox-group v-model="form.group">
                                    <checkbox :label="item.label" v-for="item in informations">
                                        <span>{{ item.text }}</span>
                                    </checkbox>
                                </checkbox-group>
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