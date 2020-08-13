/**
 * Used in views:
 *      job_log.create
 *      job_log.update
 */


/**
 *
 */
function check_services_item_id() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/services/getServicesItem",
        type: "POST",
        data: {id: $("#services_item_id").val()},
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
            $("#price").val(data.price);
            $("#total_price").val(data.price);
            $('#unit').val(data.unit);

            calc_total()
        }
    })
}

/**
 *
 */
function calc_total() {
    var requestData = {
        services_item_id: $("#services_item_id").val(),
        coefficient: $("#coefficient").val(),
        count: $("#count").val(),
    };

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/job-log/calcTotalAjax",
        type: "POST",
        dataType: 'json',
        data: requestData,
        success: function (data) {
            $("#total_price").val(data.total_price)
        }
    })
}

/**
 *
 */
function check_project() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/job-log/getJobByProject",
        type: "POST",
        data: {project_id: $("#project_id").val()},
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
            let tbody = $("#tableProjectJob tbody");
            let tfoot = $("#tableProjectJob tfoot");

            tbody.html("");
            tfoot.html("");

            if (data['data'] !== null) {
                let html = "";
                console.log(data['data']);
                data['data'].forEach((el) => {
                    html += `<tr>
                                        <td>
                                            <button onclick="deleteJobLog('/job-log/delete/${el.id}')" title="Видалити" class="btn btn-block btn-outline-danger btn-sm deleteJobLog"  ><i class="fa fa-trash"></i></button>
                                        </td>
                                        <td>${el.services_item_name.slice(0, 60)} ...</td>
                                        <td>${el.count} - ${el.unit}</td>
                                        <td>${el.coefficient}</td>
                                        <td>${el.price}</td>
                                        <td>${el.total_price}</td>
                                        <td>${el.user_creator}</td>
                                        <td>${el.date_time}</td>
                                     </tr>`;
                });
                tbody.append(html);
            }

            if (data['total'] !== null && data["total_pdv"] !== null) {
                let html = `
                            <tr>
                                <th colspan="4">Підсумок: </th>
                                <th>Сума</th>
                                <th>${data['total']}</th>
                                <th>Сума з ПДВ</th>
                                <th>${data['total_pdv']}</th>
                            </tr>
                        `;
                tfoot.html(html);
            }
        }
    })
}

$("#btnAllRefresh").click(function () {
    check_services_item_id();
});


/**
 *
 */
function getServicesItemByClientId() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/services/getServicesItemByClientId",
        type: "POST",
        dataType: 'json',
        data: {client_id: $("#client_id").val()},
        success: function (data) {
            let services_item_select = $("#services_item_id");

            services_item_select.html("");
            data.results.map(function (obj) {
                let option = new Option(obj.text, obj.id);
                $("#services_item_id").append(option);
            });
            services_item_select.val(null);
            calc_total();
        }
    })
}

/**
 * @param href
 */
function deleteJobLog(href) {
    scripts.confirmDeleteItemByHref(href)
}

$("#client_id").on("change", getServicesItemByClientId);
$("#services_item_id").on('change', check_services_item_id);
$("#coefficient").on("change", calc_total)
$("#count").on("change", calc_total)
$("#project_id").on('change', check_project);
/*$("#price").on("change", calc_total)*/
