@extends("layouts.page")
@section("plugins.Select2", true)
@section("plugins.bootstrap4Duallistbox", true)
@section("plugins.daterangepicker", true)


@section("content")

    <div class="row">
        <div class="col-12">
            <div class="card card-default collapsed-card">
                <div class="card-header">
                    <h1 class="card-title">{!! __("form.base.attr.control") !!}</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default"><i
                            class="fa fa-plus"></i> {!! __("page.job_log.create.control.btn.add_project") !!} </button>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(isset($card_title))
                            {!! $card_title !!}
                        @else
                            Card Title
                        @endif
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{Form::open(["id" => "form_job_log", "method" => "POST"])}}

                    <div class="row">
                        {{--Client--}}
                        <div class="col-6">
                            <div class="form-group">
                                {{Form::label( __("form.job_log.create.attr.client_id"))}}
                                {{Form::select("client_id", ['' => __("form.base.attr.select_empty_val")] + $formJobLog['client_id'], null, ["class" => "form-control select2", "id" => "client_id", "style" => "width: 100%"])}}
                            </div>
                        </div>
                        {{--Project--}}
                        <div class="col-6">
                            <div class="form-group">
                                {{Form::label(__("form.job_log.create.attr.project_id"))}}
                                {{Form::select("project_id", ['' => __("form.base.attr.select_empty_val")] + $formJobLog['project_id'], null, ["class" => "form-control select2", "id" => "project_id", "style" => "width: 100%"])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{--Services--}}
                            <div class="form-group">
                                {{Form::label(__("form.job_log.create.attr.services_item_id"))}}
                                {{Form::select("services_item_id", ['' => __("form.base.attr.select_empty_val")] /*+ $formJobLog['service_item_id']*/, null, ["class" => "form-control select2", "id" => "services_item_id", "style" => "width: 100%"])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{--User exec--}}
                        <div class="col-12">
                            <div class="form-group">
                                {{Form::label(__("form.job_log.create.attr.user_exec"))}}
                                {{Form::select("user_exec[]", $formJobLog['user_exec'], Auth::id(),
                                    [
                                        "class" => "duallistbox",
                                        'expanded' => true,
                                        "multiple" => "multiple",
                                        "id" => "user_exec"
                                    ]
                                )}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                {{Form::label(__("form.job_log.create.attr.count", ["for" => "countcount"]))}}
                                {{Form::number("count", "1", ["class" => "form-control", "id" => "count"])}}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                {{Form::label(__("form.job_log.create.attr.coefficient"))}}
                                {{Form::select("coefficient", $formJobLog['coefficient'], 1, ["class" => "form-control select2", "id" => "coefficient", "style" => "width: 100%"])}}
                            </div>
                        </div>
                        <div class="col-4">
                            {{--Unit--}}
                            <div class="form-group">
                                {{Form::label(__("form.service.item.attr.unit"))}}
                                {{Form::text("", "", ["class" => "form-control", "readonly" => "true", "id" => "unit"])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                {{Form::label(__("form.base.attr.date"))}}
                                {{Form::text("date_time", $formJobLog['date_time'], ["class" => "form-control float-right", "id" => "date_time"])}}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                {{Form::label(__("form.job_log.create.attr.price"))}}
                                {{Form::text("price", "0", ["class" => "form-control", /*"readonly" => "true",*/ "id" => "price"])}}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                {{Form::label(__("form.job_log.create.attr.total_price"))}}
                                {{Form::text("total_price", "0", ["class" => "form-control", "readonly" => "true", "id" => "total_price"])}}
                            </div>
                        </div>
                        <div class="col-1">
                            {{Form::label("Оновити")}}
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-success" id="btnAllRefresh">
                                    <i class="fa fa-sync"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-info collapsed-card">
                                <div class="card-header">
                                    <h3 class="card-title">{!! __("form.job_log.create.attr.comment") !!}</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"
                                                data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{Form::label(__("form.job_log.create.attr.comment"))}}
                                    {{Form::textarea("comment", "", ["class" => "form-control"])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {{Form::submit(__("basic.label.add"), ["class" => "form-control btn btn-success", "id" => "btn_add"])}}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h1 class="card-title">Додані роботи</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered table-sm" id="tableProjectJob">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Найменування робіт</th>
                            <th>Кількість - од. вим</th>
                            <th>Коефіцієнт</th>
                            <th>Ціна за од.</th>
                            <th>Сума</th>
                            <th>Створив</th>
                            <th>Вкзана дата</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include("projects.modal_create_project")
@endsection


@section('js')
    {{Html::script("js/components/job_log/create_update_form.js")}}

    <script>
        @parent
        $(function () {
            $(".select2").select2();
            $('.duallistbox').bootstrapDualListbox();
            scripts.showDatePicker("#date_time");
            $("#services_item_id").select2({});
        });
    </script>
@stop
