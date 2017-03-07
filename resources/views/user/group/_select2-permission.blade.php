@section('admin-css')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
@endsection
@section('admin-js')
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.permission-multiple').select2({
                placeholder: "请选择权限",
                tags: true
            });
        });
    </script>
@endsection