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
            };
        },
        methods: {
            submit() {
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-ban">
        </div>
    </div>
</template>