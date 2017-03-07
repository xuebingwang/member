$('[data-form-confirm]').on('click', function () {
    var $this = $(this);
    var confirm_info = $this.data('form-confirm');

    if (confirm_info == '') {
        confirm_info = '确认要执行此操作吗？';
    }

    if (confirm(confirm_info)) {
        return true;
    }

    return false;
});