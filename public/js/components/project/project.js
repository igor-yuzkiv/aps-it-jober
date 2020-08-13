$("#btnCreateProject").click(function () {
    let data = $("#formCreateProject").serialize();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/project/storeAjax",
        type: "POST",
        data: data,
        error: function (erros) {
            erros.responseJSON.forEach(function (item) {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: '{!! __("basic.messages.error") !!}',
                    body: item
                })
            })
        },
        dataType: "json",
        success: function (data) {
            location.reload();
        }
    })
})
