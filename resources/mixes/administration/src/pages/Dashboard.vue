<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.sidebar.active('member');
            next();
        },
    }
</script>
<template></template>
