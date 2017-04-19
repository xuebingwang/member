<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {
                injection.sidebar.active('member');
            });
        },
    };
</script>
<template>

</template>
