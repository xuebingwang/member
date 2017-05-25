<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/permission/get`).then(response => {
                window.console.log(response);
                const data = response.data.data;
                next(vm => {
                    vm.groups = data.groups;
                    vm.permissions = data.permissions;
                    vm.types = data.types;
                    injection.loading.finish();
                    injection.sidebar.active('member');
                });
            }).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            return {
                groups: [],
                permissions: [],
                types: [],
            };
        },
        methods: {
            change() {
                const self = this;
                self.$loading.start();
                self.$notice.open({
                    desc: '等待期间请不要继续操作！',
                    title: '正在批量更新权限值，请耐心等待...',
                });
                self.$http.post(`${window.api}/member/permission/set`, {
                    data: self.types,
                }).then(() => {
                    self.$loading.finish();
                    self.$notice.open({
                        desc: '可以继续操作了...',
                        title: '批量更新权限值成功！',
                    })
                }).catch(() => {
                    self.$loading.error();
                });
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="group-permission">
            <card :bordered="false">
                <p slot="title">用户组权限</p>
                <ul class="groups">
                    <li v-for="type in types">{{ type.attributes.name }}</li>
                </ul>
                <collapse value="global">
                    <panel :name="permission.attributes.identification" v-for="permission in permissions">
                        {{ permission.attributes.name }}
                        <template slot="content">
                            <div class="list" v-for="p in permission.permissions">
                                <ul>
                                    <li>{{ p.description }}</li>
                                    <li v-for="(t, index) in types">
                                        <i-select multiple
                                                  v-model="types[index].has[t.attributes.identification + '::' + permission.attributes.identification + '::' + p.identification]"
                                                  @on-change="change">
                                            <i-option :key="g" :value="g.identification" v-for="g in groups">{{ g.name }}</i-option>
                                        </i-select>
                                    </li>
                                </ul>
                            </div>
                        </template>
                    </panel>
                </collapse>
            </card>
        </div>
    </div>
</template>