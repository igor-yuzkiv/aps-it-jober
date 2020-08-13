@extends("layouts.form_page", ["col_classes" => "col-10 offset-1"])

@section("panel_body")

    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modal-default" title="Додати"><i class="fa fa-plus"></i></button>
    <table class="table projects" id="formTable">
        <thead>
            <tr>
                <th>Назва послуги</th>
                <th>Коефіцієнт</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ( !empty($clientInfo->monthly_services) )
                @foreach($clientInfo->monthly_services as $key => $item )
                    <tr data-key="{!! $key !!}">
                        <td>
                            {{$service_item_id[$item['services_item_id']]}}
                        </td>
                        <td>
                            {{$item['coefficient']}}
                        </td>
                        <td class="float-right">
                            <a href="{{route("client.monthlyServicesDelete", [$clientInfo->id, $item['services_item_id']])}}" class="btn btn-outline-success btn-sm" title="Видалити"><i class="fa fa-minus"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            {{Form::open(["method" => "POST", "url" => route("client.monthlyServicesAdd", $clientInfo->id)])}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Додати щомісячний платіж</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{Form::label("Назва послуги")}}
                            {{Form::select("monthly_services[0][services_item_id]", $service_item_id, null, ["class" => "form-control select2", "style" => "width: 100%"])}}
                        </div>
                        <div class="form-group">
                            {{Form::label("Коефіцієнт")}}
                            {{Form::select("monthly_services[0][coefficient]", $coefficient, 1, ["class" => "form-control select2", "style" => "width: 100%"])}}
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal" >{!! __("form.base.attr.cancel") !!}</button>
                        <button type="submit" class="btn btn-outline-success" title="Зберегти"><i class="fa fa-save"></i> Зберегти</button>
                    </div>
                </div>
            {{Form::close()}}
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section("js")
    @parent
    {{Html::script("js/components/client/monthly_services.js")}}
@stop

