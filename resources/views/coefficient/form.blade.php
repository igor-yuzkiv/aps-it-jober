@extends("layouts.simples.simple_form");


@section("js")
    @parent

    <script>

        $( "docuemnt" ).ready(function () {
            $("#services_items_id").bootstrapDualListbox({
                selectorMinimalHeight: 300
            });
        });
    </script>

@stop
