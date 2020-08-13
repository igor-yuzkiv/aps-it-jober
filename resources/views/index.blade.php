@extends("layouts.page")
@section('plugins.Datatables', true)


@section("content")

    <div class="row">
        <div class="col-md-12">
            <div class="timeline">

                @foreach($timeLineData as $data_key => $data_item)
                    <div class="time-label">
                        <span class="bg-cyan">{!! $data_key !!}</span>
                    </div>

                    @foreach($data_item as $item)

                        <div>
                            <i class="fa fa-money-bill-alt bg-green"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {!! $item->time !!}</span>
                                <h3 class="timeline-header">
                                    <span class="text-blue text-bold">{!! $item->user_name !!}</span>
                                    надав послугу
                                    <span class="text-blue text-bold">{!! $item->client_name !!}</span>
                                    на
                                    <span class="text-danger text-bold">{!! round($item->total_price, config("my.round.public")) !!} грн. </span>
                                </h3>

                                <div class="timeline-body">
                                    {!! $item->services_item_name !!}
                                </div>
                                {{--<div class="timeline-footer">
                                    <a class="btn btn-primary btn-sm">Read more</a>
                                    <a class="btn btn-danger btn-sm">Delete</a>
                                </div>--}}
                            </div>
                        </div>

                    @endforeach

                @endforeach

                {{--<div class="time-label">
                    <span class="bg-red">10 Feb. 2014</span>
                </div>
                --}}
        </div>
        <!-- /.col -->
    </div>

@stop
