@extends("layouts.page")
@section('plugins.Datatables', true)
@section("plugins.daterangepicker", true)
@section("plugins.Select2", true)
@section("plugins.bootstrap4Duallistbox", true)


@section("content")
    {{Form::open(["method" => "GET", "url" => route("job_log.reporting.exportReport")])}}
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Формувати звіт</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"
                        data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {{Form::label("Колонки")}}
                        {{Form::select(
                            "columns[]",
                            $options['columns'],
                            isset($_GET['columns']) ? $_GET['columns'] : null,
                            [
                                "class" => "duallistbox",
                                'expanded' => true,
                                "multiple" => "multiple",
                                "id" => "columns"
                            ]
                        )}}
                    </div>
                </div>
            </div>
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
                        {{Form::label("Клієнт")}}
                        {{Form::select("client_id", ['' => "Усі"] + $filterData["client_id"], isset($_GET['client_id']) ? $_GET['client_id'] : null, ["id" => "client_id", "class" => "form-control select2",])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {{Form::button("<i class='fa fa-download'></i> Завантажити", ["class" => "form-control btn-success", "type" => "submit"])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{Form::close()}}
@endsection


@section("js")
    @parent
    {{Html::script("js/components/job_log/build_report.js")}}



@endsection
