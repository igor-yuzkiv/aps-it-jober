@extends("layouts.page")
@section('plugins.Datatables', true)

@section ('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h1 class="card-title">{!! __("form.base.attr.control") !!}</h1>
                    @yield("control_card_header")
                </div>
                <div class="card-body">
                    @yield("control_card")
                </div>
            </div>
        </div>
    </div>

    @yield("before_table")

    <div class="row">
        <div class="col-12 col-sm-10 col-md-6 col-lg-12">
            <div class="card-dark">
                <div class="card-header">
                    <h3 class="card-title">
                        @if( isset($card_title) ) {!! $card_title !!} @else Card Title @endif
                    </h3>
                </div>

                <div class="card-body">
                    <table @if (isset($id_data_table)) id="{!! $id_data_table !!}" @else id="dataTable" @endif
                            class="@if (isset($table_classes)) {!! $table_classes !!} @else table table-bordered table-striped table-sm responsive @endif
                            @if(!isset($nowrap)) nowrap @elseif(isset($nowrap) and $nowrap) nowrap @else @endif"

                           style="width:100%">
                        <thead>
                        @yield("table_header")
                        </thead>
                        <tbody class="table-hover">
                        @yield("table_body")

                        </tbody>
                        <tfoot>
                        @yield("table_footer")
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        @parent
        $(function () {
            let  table = scripts.showDataTable("#dataTable");
        });
    </script>
@stop




