@extends("layouts.data_table", ["nowrap" => false])
@section("plugins.Select2", true)
@section("plugins.bootstrap4Duallistbox", true)
@section("plugins.daterangepicker", true)


@section("control_card_header")
    <div class="card-tools">
        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"
                data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i>
        </button>
    </div>
@endsection

@section("control_card")
    <div class="row">
        <div class="col-12">
            {{Form::open(["method" => "GET"])}}
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label( __("form.job_log.create.attr.client_id"))}}
                        {{Form::select("services_item_client_id[]", ['' => __("form.base.attr.select_empty_val")] + $formFilter['services_item_client_id'], isset($_GET['services_item_client_id']) ? $_GET['services_item_client_id'] : null, ["class" => "form-control select2", "id" => "services_item_client_id"])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {{Form::submit("Фільтрувати", ["class" => "btn btn-info"] )}}
                        <a href="{{route("services.item.index")}}" class="btn btn-warning">Зкинути фільтри</a>
                    </div>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="{{route("services.item.create")}}" class="btn btn-success"> <i class="fa fa-plus"></i> {!! __("basic.label.add") !!} </a>
        </div>
    </div>
@endsection

@section("table_header")
    <tr>
        <th>{!! __("form.base.attr.id") !!}</th>
        <th></th>
        <th></th>
        <th>{!! __("form.service.item.attr.name") !!}</th>
        <th>{!! __("form.service.item.attr.price") !!}</th>
        <th>{!! __("form.service.item.attr.unit") !!}</th>
        <th>{!! __("form.service.item.attr.service_group") !!}</th>
        <th>{!! __("page.base.labels.isDeleted") !!}</th>
        <th>{!! __("form.job_log.create.attr.client_id") !!}</th>
        <th>{!! __("form.base.attr.created") !!}</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
    </tr>
@endsection

@section("table_body")
    @foreach($dataForTable as $item)
        <tr>
            <td>{!! $item->id !!}</td>
            <td>
                <a href="{{route("services.item.edit", $item->id)}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-block btn-outline-success btn-sm "><i class="fa fa-edit"></i></a>
            </td>
            <td>
                <button data-href="{{route("services.item.destroy", "$item->id")}}" title="Видалити" class="btn btn-block btn-outline-danger btn-sm deleteItem"  ><i class="fa fa-trash"></i></button>
            </td>
            <td class="w-25">{!! $item->name !!}</td>
            <td>{!! $item->price !!}</td>
            <td>{!! $item->unit !!}</td>
            <td>{!! $item->service_group !!}</td>
            <td>
                @if($item->is_deleted)
                    <span class="badge badge-danger">{!! __("page.base.labels.yes") !!}</span>
                @else
                    <span class="badge badge-success">{!! __("page.base.labels.no") !!}</span>
                @endif
            </td>
            <td>{!! $item->client_name !!}</td>
            <td>{!! $item->created_at !!}</td>
            <td>{!! $item->updated_at !!}</td>
        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th>{!! __("form.base.attr.id") !!}</th>
        <th></th>
        <th></th>
        <th>{!! __("form.service.item.attr.name") !!}</th>
        <th>{!! __("form.service.item.attr.price") !!}</th>
        <th>{!! __("form.service.item.attr.unit") !!}</th>
        <th>{!! __("form.service.item.attr.service_group") !!}</th>
        <th>{!! __("page.base.labels.isDeleted") !!}</th>
        <th>{!! __("form.job_log.create.attr.client_id") !!}</th>
        <th>{!! __("form.base.attr.created") !!}</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
    </tr>
@endsection

@section("js")
    @parent
    <script>
        $(document).ready(function () {
            $(".select2").select2();
        });

        $(".deleteItem").on("click", function () {
            let href = $(this).attr("data-href");
            scripts.confirmDeleteItemByHref(href)
        })
    </script>
@stop
