@extends("layouts.data_table")

@section("control_card")
    <a href="{{route("client.create")}}" class="btn btn-success"> <i class="fa fa-plus"></i>  {!! __("basic.label.add") !!}</a>
@endsection

@section("table_header")
    <tr>
        <th>{!! __("form.base.attr.id") !!}</th>
        <th></th>
        <th>{!! __("form.client.attr.name") !!}</th>
        <th>Коротка назва</th>
        <th>{!! __("form.base.attr.position") !!}</th>
    </tr>
@endsection

@section("table_body")
    @foreach($clientDataTable as $item)
        <tr>
            <td> {!! $item->id !!} </td>
            <td>
                <a href="{{route("client.edit", "$item->id")}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-sm  btn-outline-info"><i class="fa fa-edit"></i></a>
                <button data-href="{{route("client.destroy", "$item->id")}}" title="{!! __("page.basic.label.delete") !!}"  class="btn btn-sm  btn-outline-danger deleteItem"><i class="fa fa-trash"></i></button>
                <a href="{{route("client.monthlyServicesForm", "$item->id")}}" title="Щомісячні послуги" class="btn btn-sm  btn-outline-warning"><i class="fa fa-list"></i></a>
            </td>
            <td class="w-75"> {!! $item->name !!} </td>
            <td class="w-75"> {!! $item->short_name !!} </td>
            <td> {!! $item->position !!} </td>
        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th>{!! __("form.base.attr.id") !!}</th>
        <th></th>
        <th>{!! __("form.client.attr.name") !!}</th>
        <th>Коротка назва</th>
        <th>{!! __("form.base.attr.position") !!}</th>
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
