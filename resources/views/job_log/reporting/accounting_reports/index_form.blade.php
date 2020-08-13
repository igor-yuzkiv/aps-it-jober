@extends("layouts.page")
@section('plugins.Datatables', true)
@section("plugins.daterangepicker", true)
@section("plugins.Select2", true)
@section("plugins.bootstrap4Duallistbox", true)


@section("content")

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Звіт для бухгалтерії</h3>
        </div>
        <div class="card-body">

            {{Form::open(["method" => "POST", "url" => ""])}}

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label("Місяць")}}
                        {{Form::select("mouth", $formData["month_list"], date("m"), ["class" => "select2", "style" => "width:100%", "id" => "month"])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        {{Form::label("Клієнт")}}
                        {{Form::select("client_id", $formData["clients"], null, ["class" => "select2", "style" => "width:100%", "id" => "client_id" ])}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {{Form::button("Формувати", ["class" => "btn btn-outline-success", "id" => "createReportForAccounting"])}}
                    </div>
                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>

@endsection


@section("js")
    @parent
    {{Html::script("js/components/job_log/Reporting/AccountingReports/index_form.js")}}
    <script>
        $(function () {
            $(".select2").select2();
        });
    </script>

@endsection
