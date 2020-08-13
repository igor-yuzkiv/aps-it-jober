@extends("layouts.form_page")

@section("panel_body")
    {!! form($form) !!}
@endsection

@section('js')
    @parent
    <script>
        $(function () {
            $(".select2").select2();
        });
    </script>
@stop
