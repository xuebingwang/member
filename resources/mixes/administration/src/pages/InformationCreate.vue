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
                    description: '',
                    detail: false,
                    groups: [],
                    name: '',
                    privacy: '',
                    register: false,
                    required: false,
                    type: 'input',
                },
                groups: [
                    {
                        label: 'base',
                        text: '资料',
                    },
                ],
                privacies: [
                    {
                        label: '管理员可见',
                        value: 'admin',
                    },
                ],
                rules: {},
                types: [
                    {
                        label: 'input',
                        text: '单行文本框',
                    },
                    {
                        label: 'textarea',
                        text: '多行文本框',
                    },
                    {
                        label: 'radio',
                        text: '单选框',
                    },
                    {
                        label: 'checkbox',
                        text: '复选框',
                    },
                    {
                        label: 'dropdown',
                        text: '下拉菜单',
                    },
                    {
                        label: 'select',
                        text: '多选列表框',
                    },
                    {
                        label: 'file',
                        text: '上传图片',
                    },
                ],
            };
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-create">
            <card>
                <p slot="title">创建信息</p>
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
                            <form-item label="分组介绍" prop="description">
                                <i-input placeholder="请输入分组介绍" v-model="form.description"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="表单类型">
                                <radio-group v-model="form.type" vertical>
                                    <radio :label="item.label" v-for="item in types">
                                        <span>{{ item.text }}</span>
                                    </radio>
                                </radio-group>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="大小限定" prop="description">
                                <i-input placeholder="请输入分组介绍" v-model="form.description"></i-input>
                                <p>最多可填写的字符数或最多可选择的项数,图片类型时限制了上传图片大小(单位:KB)。</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="可选值" prop="users">
                                <i-input type="textarea" placeholder="请输入自我介绍" v-model="form.signature"
                                         :autosize="{minRows: 5,maxRows: 9}"></i-input>
                                <p>每行一个值，例如输入:</p>
                                <p>北京</p>
                                <p>上海</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="注册页显示">
                                <i-switch v-model="form.register" size="large">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                </i-switch>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="资料页显示">
                                <i-switch v-model="form.detail" size="large">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                </i-switch>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="必填项">
                                <i-switch v-model="form.required" size="large">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                </i-switch>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="隐私级别">
                                <i-select v-model="form.privacy">
                                    <i-option v-for="item in privacies" :value="item.value" :key="item">{{ item.label }}</i-option>
                                </i-select>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="用户资料分组">
                                <checkbox-group v-model="form.group">
                                    <checkbox :label="item.label" v-for="item in groups">
                                        <span>{{ item.text }}</span>
                                    </checkbox>
                                </checkbox-group>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="显示顺序" prop="description">
                                <i-input placeholder="请输入分组介绍" v-model="form.description"></i-input>
                                <p>值越大显示越靠后。</p>
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