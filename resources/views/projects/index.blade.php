@extends("layouts.data_table", ["table_classes" => "table table-striped projects", "nowrap" => false])

@section("content")
    @parent
    @include("projects.modal_create_project")
@stop

@section("control_card")
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default"> <i class="fa fa-plus"></i>  {!! __("basic.label.add") !!}</button>
@endsection

@section("table_header")
    <tr>
        <th>{!! __("form.base.attr.name") !!}</th>
        <th>Статус проекту</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
        <th></th>
    </tr>
@endsection

@section("table_body")
    @foreach($projectDataTable as $item)
        <tr>
            <td>
                <a>
                    {!! $item->name !!}
                </a>
                <br/>
                <small>
                    {!! __("form.base.attr.created") !!}:
                    {!! $item->created_at !!}
                </small>
            </td>
            <td>
                @if(!$item->is_close)
                    <span class="badge badge-success">Проект в роботі</span>
                @else
                    <span class="badge badge-warning">{!! __("form.project.attr.isClose") !!}</span>
                @endif
            </td>
            <td> {!! $item->updated_at !!} </td>

            <td class="project-actions text-right">
                <a href="{{route("project.edit", $item->id)}}" class="btn btn-info btn-sm" title="{!! __("page.basic.label.edit") !!}">
                    <i class="fa fa-edit"></i>
                    Редагувати
                </a>
                <a href="{{route("project.details_info", $item->id)}}" class="btn btn-primary btn-sm" title="Детальніше">
                    <i class="fas fa-folder"></i>
                    Детальніше
                </a>
            </td>

        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th>{!! __("form.base.attr.name") !!}</th>
        <th>Статус проекту</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
        <th></th>
    </tr>
@endsection
