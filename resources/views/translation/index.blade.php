@extends("layouts.data_table")

@section("control_card")
    <a href="{{route("translations.create")}}" class="btn btn-success"> <i class="fa fa-plus"></i>  {!! __("basic.label.add") !!}</a>
@endsection

@section("table_header")
    <tr>
        <th>{!! __("form.base.attr.id") !!}</th>
        <th></th>
        <th>{!! __("form.translations.attr.locale") !!}</th>
        <th>{!! __("form.translations.attr.full_patch") !!}</th>
        <th>{!! __("form.translations.attr.text") !!}</th>
        <th>{!! __("form.translations.attr.namespace") !!}</th>
        <th>{!! __("form.translations.attr.group") !!}</th>
        <th>{!! __("form.translations.attr.item") !!}</th>
        <th>{!! __("form.base.attr.created") !!}</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
    </tr>
@endsection

@section("table_body")
    @foreach($dataTable as $item)
        <tr>
            <td>{!! $item->id !!}</td>
            <th>
                <a href="{{route("translations.edit", $item->id)}}" title="{!! __("page.basic.label.edit") !!}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                <button data-href="{{route("translations.destroy", "$item->id")}}" title="{!! __("page.basic.label.delete") !!}"  class="btn btn-sm  btn-outline-danger deleteItem"><i class="fa fa-trash"></i></button>
            </th>
            <td>{!! $item->locale !!}</td>
            <th>{!! $item->group !!}.{!! $item->item !!} </th>
            <th>{!! \Illuminate\Support\Str::limit($item->text, 80, "...") !!}</th>
            <td>{!! $item->namespace !!}</td>
            <td>{!! $item->group !!}</td>
            <td>{!! $item->item !!}</td>
            <td>{!! $item->created_at !!}</td>
            <td>{!! $item->updated_at !!}</td>
        </tr>
    @endforeach
@endsection

@section("table_footer")
    <tr>
        <th>{!! __("form.base.attr.id") !!}</th>
        <th></th>
        <th>{!! __("form.translations.attr.locale") !!}</th>
        <th>{!! __("form.translations.attr.full_patch") !!}</th>
        <th>{!! __("form.translations.attr.text") !!}</th>
        <th>{!! __("form.translations.attr.namespace") !!}</th>
        <th>{!! __("form.translations.attr.group") !!}</th>
        <th>{!! __("form.translations.attr.item") !!}</th>
        <th>{!! __("form.base.attr.created") !!}</th>
        <th>{!! __("form.base.attr.updated") !!}</th>
    </tr>
@endsection

@section("js")
    @parent
    <script>
        $(".deleteItem").on("click", function () {
            let href = $(this).attr("data-href");
            scripts.confirmDeleteItemByHref(href)
        })
    </script>
@stop

