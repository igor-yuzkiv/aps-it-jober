@extends("layouts.page")


@section("content")

    <div class="row">
        <div class="col-10 offset-1">
            <h2 class="text-success">Додано щомісячні послуги</h2>
            <a href="{{route("job_log.reporting.accounting.getAddedServices", ["client_id" => $client_id, "month" => date("m")])}}"><i class="fa fa-download"></i> Завантажити звіт за поточний місяць </a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Назва послуги</th>
                    <th>Кількість</th>
                    <th>Коефіцієнт</th>
                    <th>Ціна</th>
                    <th>Сума</th>
                    <th>Дата виконання</th>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($data["added"]))

                        @foreach($data["added"] as $item)
                            <tr>
                                <td>{!! $item["services_item"]->name !!}</td>
                                <td>{!! $item["job_log"]->count !!}</td>
                                <td>{!! $item["job_log"]->coefficient !!}</td>
                                <td>{!! $item["job_log"]->price !!}</td>
                                <td>{!! $item["job_log"]->total_price !!}</td>
                                <td>{!! $item["job_log"]->date_time !!}</td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <th style="text-align: center" colspan="6">Для цього клієнта усі щомісячні послуги уже додано</th>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

