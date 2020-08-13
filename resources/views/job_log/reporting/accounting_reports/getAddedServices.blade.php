@extends("layouts.page")


@section("content")

    {{Form::open(["method" => "POST", "url" => route("job_log.reporting.accounting.downloadReport")])}}

    {{Form::hidden("client_id", $client_id)}}
    {{Form::hidden("month", $month)}}

    <div class="card card-default" >
        <div class="card-header">
            <h3 class="card-title">
                Надані послуги <strong>{!! $client_name !!}</strong> за {!! $month_name !!}
            </h3>
        </div>
        <div class="card-body">
           <div class="row">
               <div class="col-12">
                    <div class="form-group">
                        {{Form::submit("Завантажити звіт без обраних послгу", ["class" => "btn btn-outline-success"])}}
                    </div>
               </div>
           </div>
           <div class="row">
               <div class="col-12">
                   <table class="table table-hover table-bordered table-sm">
                       <thead>
                       <tr>
                           <th></th>
                           <th>Назва послуги</th>
                           <th>Загальна кількість</th>
                           <th>Сума</th>
                       </tr>
                       </thead>
                       <tbody>

                       @if (!$data->isEmpty())
                           @foreach($data as $item)
                               <tr>
                                   <td>
                                       {{Form::checkbox("remove_from_report[]", $item->id)}}
                                   </td>
                                   <td>{!! $item->name !!}</td>
                                   <td>{!! $item->count !!}</td>
                                   <td>{!! $item->total_price !!}</td>
                               </tr>
                           @endforeach
                       @else

                       @endif

                       </tbody>
                   </table>
               </div>
           </div>
        </div>
    </div>
    {{Form::close()}}

@endsection()
