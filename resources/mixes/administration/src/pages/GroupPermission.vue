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
            };
        },
    };
</script>
<template>

</template>