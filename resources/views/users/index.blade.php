@extends("layouts.data_table", ["table_classes" => "table table-striped projects", "nowrap" => false])

@section("control_card")
    <a href="{{route("users.create")}}" class="btn btn-success"> <i class="fa fa-plus"></i>  {!! __("basic.label.add") !!}</a>
@endsection

@section("table_header")
    <tr>
        <th>ID</th>
        <th></th>
        <th>Назва</th>
        <th>E-mail</th>
        <th></th>
    </tr>
@endsection

@section("table_body")
    @foreach($dataTable as $item)
        <tr>
            <td>{!! $item->id !!}</td>
            <td>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <img alt="Avatar" class="table-avatar" src="{{Storage::url($item->avatar)}}">
                    </li>
                </ul>
            </td>
            <td>{!! $item->name !!}</td>
            <td>{!! $item->email !!}</td>

            <td class="project-actions text-right">
                <a href="{{route("users.edit", "$item->id")}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-sm  btn-outline-info"><i class="fa fa-edit"></i></a>
                <a href="{{route("users.resetPassword", "$item->id")}}" title="Змінити пароль" class="btn btn-sm  btn-outline-primary"><i class="fa fa-key"></i></a>
                <button data-href="{{route("users.destroy", "$item->id")}}" title="{!! __("page.basic.label.delete") !!}" class="btn btn-sm  btn-outline-danger deleteItem"> <i class="fa fa-trash"></i> </button>
            </td>

        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th>ID</th>
        <th></th>
        <th>Назва</th>
        <th>E-mail</th>
        <th></th>
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
