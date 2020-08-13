@extends("layouts.data_table")

@section("control_card")
    <a href="{{route("coefficient.create")}}" class="btn btn-success"> <i class="fa fa-plus"></i>  {!! __("basic.label.add") !!}</a>
@endsection

@section("table_header")
    <tr>
        <th>ID</th>
        <th></th>
        <th>Назва</th>
        <th>Значення</th>
    </tr>
@endsection

@section("table_body")
    @foreach($dataTable as $item)
        <tr>
            <td>{!! $item->id !!}</td>
            <td>
                <a href="{{route("coefficient.edit", "$item->id")}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-sm  btn-outline-info"><i class="fa fa-edit"></i></a>
                <button data-href="{{route("coefficient.destroy", "$item->id")}}" title="{!! __("page.basic.label.delete") !!}" class="btn btn-sm  btn-outline-danger deleteItem"><i class="fa fa-trash"></i></button>
            </td>
            <td>{!! $item->name !!}</td>
            <td>{!! $item->value !!}</td>

        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th>ID</th>
        <th></th>
        <th>Назва</th>
        <th>Значення</th>
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
