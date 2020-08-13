@extends("layouts.data_table")
@section("plugins.daterangepicker", true)
@section("plugins.Select2", true)


@section("control_card")
    {{Form::open(["method" => "GET" ,"id" => "filter"])}}
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::label("Дата виконання")}}
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    {{Form::text("data_time_between", isset($_GET['data_time_between']) ? $_GET['data_time_between'] : "", ["class" => "form-control float-right", "id" => "data_time_between"])}}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::label("Виконували")}}
                {{Form::select("user_exec", ['' => "Усі"] + $filterData["user_exec"], isset($_GET['user_exec']) ? $_GET['user_exec'] : null, ["id" => "user_exec", "class" => "form-control select2",])}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::label("Клієнт")}}
                {{Form::select("client_id", ['' => "Усі"] + $filterData["client_id"], isset($_GET['client_id']) ? $_GET['client_id'] : null, ["id" => "client_id", "class" => "form-control select2",])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {{Form::submit("Фільтрувати", ["class" => "btn btn-info", "id" => "filter_submit"])}}
            <a href="{{route("job_log.showJobLog")}}" class="btn btn-info"> <i class="fa fa-plus"></i> Зкинути фільтри </a>
            <a href="{{route("job_log.create")}}" class="btn btn-success"> <i class="fa fa-plus"></i>  {!! __("basic.label.add") !!}</a>
        </div>
    </div>
    {{Form::close()}}
@endsection


{{----}}

@section("before_table")
    <table class="table table-bordered table-sm">
        <tr>
            <th>Сума:</th>
            <th>{!! round($total["total"], config("my.round.public")) !!}</th>
            <th>Сума з ПДВ:</th>
            <th>{!! round($total["total_pdv"], config("my.round.public")) !!}</th>
        </tr>
    </table>

    {{$dataTable->withQueryString()->links()}}
@endsection

@section("table_header")
    <tr>
        <th></th>
        <th></th>
        <th>Назва послуги</th>
        <th>Клієнт</th>
        <th>Виконавці</th>
        <th>Проект</th>
        <th>Ціна</th>
        <th>Кількість</th>
        <th>Коефіцієнт</th>
        <th>Сума</th>
        <th>Дата виконання</th>
        <th>Дата створення</th>
        <th>Дата оновлення</th>
        <th>Створив</th>
        <th>Примітка</th>
    </tr>
@endsection

@section("table_body")
    @foreach($dataTable as $item)
        <tr>
            <td>
                @if(!$item->project_is_close)
                    <a href="{{route("job_log.formUpdate", "$item->id")}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-block btn-outline-success btn-sm"><i class="fa fa-edit"></i></a>
                @endif
            </td>
            <td>
                <button data-href="{{route("job_log.delete", "$item->id")}}" title="Видалити" class="btn btn-block btn-outline-danger btn-sm deleteJobLog"  ><i class="fa fa-trash"></i></button>
            </td>
            <td data-order = "{{ $item->services_item_name_order }}">
                <a href="{{route("job_log.formUpdate", "$item->id")}}" title="{!! $item->services_item_name !!}" target="_blank">
                    {{ \Illuminate\Support\Str::limit($item->services_item_name, 40, "...") }}
                </a>
            </td>
            <td>{!! $item->client_name !!}</td>
            <td>{!! $item->user_exec_name !!}</td>
            <td>
                <a href="{{route("project.details_info", $item->project_id ?? "#" )}}" title="{!! $item->project_name !!}" target="_blank">
                    {{ \Illuminate\Support\Str::limit($item->project_name, 40, "...") }}
                </a>
            </td>
            <td>{!! $item->price !!}</td>
            <td>{!! $item->count !!}</td>
            <td>{!! $item->coefficient !!}</td>
            <td>{!! $item->total_price !!}</td>
            <td>{!! $item->date_time !!}</td>
            <td>{!! $item->created_at !!}</td>
            <td>{!! $item->updated_at !!}</td>
            <td>{!! $item->user_create !!}</td>
            <td>{!! $item->comment !!}</td>
        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th></th>
        <th></th>
        <th>Назва послуги</th>
        <th>Клієнт</th>
        <th>Виконавці</th>
        <th>Проект</th>
        <th>Ціна</th>
        <th>Кількість</th>
        <th>Коефіцієнт</th>
        <th>Сума</th>
        <th>Дата виконання</th>
        <th>Дата створення</th>
        <th>Дата оновлення</th>
        <th>Створив</th>
        <th>Примітка</th>
    </tr>
@endsection

@section("js")
    <script>
        $(document).ready(function () {

            scripts.showDateRangePicker("#data_time_between")

            let table = $("#jobLogDataTable").DataTable({
                language: scripts.getDataTableLanguageOptions(),
                paging: false,
                lengthChange: false,
                searching: false,
                ordering: true,
                info: false,
                autoWidth: false,
                responsive: true,
                pageLength: 50,
            });

            table.order([[10, 'desc']]).draw();
        });

        $(".deleteJobLog").on("click", function () {
            let href = $(this).attr("data-href");
            scripts.confirmDeleteItemByHref(href)
        })

    </script>
@stop

