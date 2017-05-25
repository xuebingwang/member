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
    };
</script>
<template>
    <div class="member-warp">
        <div class="group-permission">
            <card :bordered="false">
                <p slot="title">用户组权限</p>
                <ul class="groups">
                    <li v-for="type in types">{{ type.name }}</li>
                </ul>
                <collapse value="global">
                    <panel :name="permission.attributes.identification" v-for="permission in permissions">
                        {{ permission.attributes.name }}
                        <template slot="content">
                            <div class="list" v-for="p in permission.permissions">
                                <ul>
                                    <li>{{ p.description }}</li>
                                    <li v-for="t in types">
                                        <i-select multiple>
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