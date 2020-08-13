@if ($errors->any())
@section("js")



    <script>
        @foreach ($errors->all() as $error)
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: '{!! __("basic.messages.error") !!}',
            body: "{!! $error !!}"
        })
        @endforeach
    </script>

@append
@endif
