@extends("layouts.page")
@section("plugins.Select2", true)
@section("plugins.bootstrap4Duallistbox", true)


@section("content")
    <div class="row">
        <div @if (isset($col_classes) ) class="{!! $col_classes !!}" @else class="col-sm-8 offset-2" @endif>
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(isset($card_title))
                            {!! $card_title !!}
                        @else
                            Card Title
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    @yield("panel_body")
                </div>
            </div>
        </div>
    </div>
@endsection


