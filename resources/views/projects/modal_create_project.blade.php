<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{!! __("page.project.create.title") !!}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! form($formCreateProject) !!}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal" >{!! __("form.base.attr.cancel") !!}</button>
                <button type="button" class="btn btn-primary" id="btnCreateProject">{!! __("basic.label.save") !!}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

@section("js")
    @parent
    {{Html::script("js/components/project/project.js")}}
@stop
