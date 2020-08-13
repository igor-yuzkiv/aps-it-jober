@if(session()->has('message'))
@section("js")
    <script>
        @if (is_array(session()->get('message') ))
        @foreach(session()->get('message') as $item)
        $(document).Toasts('create', {
            class: 'bg-info',
            title: '{!! __("basic.messages.message") !!}',
            body: "{!! $item !!}"
        });
        @endforeach
        @else
        $(document).Toasts('create', {
            class: 'bg-info',
            title: '{!! __("basic.messages.message") !!}',
            body: "{!! session()->get('message') !!}"
        });
        @endif
    </script>
@append
@endif
