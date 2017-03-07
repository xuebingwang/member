@section('admin-css')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
@endsection

@section('admin-js')
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.groups-multiple').select2({
                placeholder: "选择一些选项",
                tags: true
            });
        });
    </script>
@endsection