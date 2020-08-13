/**
 * Used in:
 *      services_item.create
 *      services_item.update
 */


function check_services_group() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/services/getServicesGroupByClientId",
        type: "POST",
        dataType: 'json',
        data: {client_id: $("#client_id").val()},
        success: function (data) {
            $("#services_group_id").html("");
            data.results.map(function (obj) {
                let option = new Option(obj.text, obj.id);
                $("#services_group_id").append(option);
            });
        }
    })
}

$("#client_id").on("change", function () {
    check_services_group();
});
