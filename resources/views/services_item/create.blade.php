@extends("layouts.simples.simple_form");


@section("js")
    @parent
    {{Html::script("js/components/services_item/create.js")}}
    <script>
        $("document").ready(function () {
            check_services_group();
        });
    </script>

@stop
