<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.all([
                injection.http.post(`${window.api}/member/tag/list`),
                injection.http.post(`${window.api}/member/user`, {
                    id: to.params.id,
                }),
                injection.http.post(`${window.api}/member/user/tag`, {
                    id: to.params.id,
                }),
            ]).then(injection.http.spread((tags, user, relations) => {
                next(vm => {
                    const has = [];
                    relations.data.data.forEach(relation => {
                        has.push(relation.tag_id);
                    });
                    tags.data.data.forEach(tag => {
                        let relate = false;
                        has.forEach(item => {
                            if (tag.id === item) {
                                relate = true;
                            }
                        });
                        tag.has = relate;
                    });
                    vm.tags = tags.data.data;
                    vm.user = user.data.data;
                    injection.loading.finish();
                    injection.sidebar.active('member');
                });
            })).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            return {
                loading: false,
                tags: [],
                user: {},
            };
        },
        methods: {
            submit() {
                const self = this;
                self.loading = true;
                if (!self.user.id) {
                    self.loading = false;
                    self.$notice.error({
                        title: '用户不存在！',
                    });
                }
                const has = [];
                self.tags.forEach(item => {
                    if (item.has) {
                        has.push(item.id);
                    }
                });
                self.$http.post(`${window.api}/member/tag/user`, {
                    id: self.user.id,
                    tags: has,
                }).then(() => {
                    self.$notice.open({
                        title: '更新用户标签成功！',
                    });
                    self.$router.push('/member/user');
                }).finally(() => {
                    self.loading = false;
                });
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-create">
            <card>
                <p slot="title">编辑用户标签</p>
                <i-form :label-width="200">
                    <row>
                        <i-col span="12">
                            <form-item label="用户名">
                                <span>{{ user.name }}</span>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="标签">
                                <checkbox :label="item.id" v-for="item in tags" v-model="item.has">
                                    <span>{{ item.tag }}</span>
                                </checkbox>
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