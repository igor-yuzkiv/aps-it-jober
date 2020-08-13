@extends("layouts.data_table")

@section("control_card")
    <a href="{{route("services.group.create")}}" class="btn btn-success"> <i class="fa fa-plus"></i> {!! __("basic.label.add") !!} </a>
@endsection

@section("table_header")
    <tr>
        <th>{!! __("form.base.attr.id") !!}</th>
        <th></th>
        <th></th>
        <th>{!! __("form.service.group.attr.name") !!}</th>
        <th>{!! __("page.base.labels.isDeleted") !!}</th>
        <th>{!! __("form.client.attr.name") !!}</th>
        <th>{!! __("form.base.attr.created") !!}</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
    </tr>
@endsection

@section("table_body")
    @foreach($dataForTable as $item)
        <tr>
            <td>{!! $item->id !!}</td>
            <td>
                <a href="{{route("services.group.edit", $item->id)}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-block btn-outline-success btn-sm "><i class="fa fa-edit"></i></a>
            </td>
            <td>
                <button data-href="{{route("services.group.destroy", "$item->id")}}" title="Видалити" class="btn btn-block btn-outline-danger btn-sm deleteItem"  ><i class="fa fa-trash"></i></button>
            </td>
            <td>{!! $item->name !!}</td>
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
        <th>{!! __("form.service.group.attr.name") !!}</th>
        <th>{!! __("page.base.labels.isDeleted") !!}</th>
        <th>{!! __("form.client.attr.name") !!}</th>
        <th>{!! __("form.base.attr.created") !!}</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
    </tr>
@endsection

@section("js")
    @parent

    <script>
        $(".deleteItem").on("click", function () {
            let href = $(this).attr("data-href");
            scripts.confirmDeleteItemByHref(href)
        })
    </script>
@stop
