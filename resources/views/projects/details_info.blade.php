@extends("layouts.data_table")
@section("control_card")
    @if(!$project_info->is_close)
        <button data-href="{{route("project.close", $project_info->id)}}" class="btn btn-warning closeProject" title="{!! __("page.project.showAll.label.project_close") !!}"><i class="fa fa-times"></i> {!! __("page.project.showAll.label.project_close") !!}</button>
    @else
        <a href="{{route("project.close", $project_info->id)}}" class="btn btn-warning" title="{!! __("page.project.showAll.label.project_open") !!}"><i class="fa fa-circle"></i> {!! __("page.project.showAll.label.project_open") !!}</a>
    @endif

    <button data-href="{{route("project.destroy", $project_info->id)}}" title="Видалити" class="btn btn-danger deleteProject"  ><i class="fa fa-trash"></i>  {!! __("page.basic.label.delete") !!}</button>
@endsection

@section("table_header")
    <tr>
        <th></th>
        <th>Назва послуги</th>
        <th>Ціна</th>
        <th>Кількість</th>
        <th>Коефіцієнт</th>
        <th>Сума</th>
        <th>Створив користувач</th>
        <th>Виконавці</th>
        <th>Дата</th>
        <th>Створенно</th>
    </tr>
@endsection

@section("table_body")
    @foreach($dataTable as $item)
        <tr>
            <td>
                @if(!$item->project_is_close)
                    <a href="{{route("job_log.formUpdate", "$item->id")}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                @endif
            </td>
            <td>
                <a href="{{route("services.item.edit", $item->services_item_id )}}" title="{!! $item->services_item_name !!}" target="_blank">
                    {{ \Illuminate\Support\Str::limit($item->services_item_name, 50, "...") }}
                </a>
            </td>
            <td>{!! $item->price !!}</td>
            <td>{!! $item->count !!}</td>
            <td>{!! $item->coefficient !!}</td>
            <td>{!! $item->total_price !!}</td>
            <td>{!! $item->user_creator !!}</td>
            <td>{{$item->user_exec_name}}</td>
            <td>{!! $item->date_time !!}</td>
            <td>{!! $item->created_at !!}</td>
        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th colspan="4">Підсумок:</th>
        <th colspan="2">Сума:</th>
        <th>{!! $total !!}</th>
        <th colspan="2">Сума з ПДВ:</th>
        <th>{!! $total_pdv !!}</th>
    </tr>
@endsection


@section("js")
    @parent
    <script>
        $(".deleteProject").on("click", function () {
            let href = $(this).attr("data-href");
            scripts.confirmDeleteItemByHref(href, "Увага", "Ви впевненні що хочете видалити цей проект?")
        })

        $(".closeProject").on("click", function () {
            let href = $(this).attr("data-href");
            scripts.confirmDeleteItemByHref(href, "Увага", "Ви впевненні що хочете закрити цей проект?", 'Закрити')
        })
    </script>
@stop
