function getClientId() {
    return $("#client_id").val();
}

function getMonth() {
    return $("#month").val();
}


$("#createReportForAccounting").click(function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/job-log/checkMonthlyJobByClientId",
        type: "POST",
        dataType: 'json',
        data: {client_id: getClientId },
        success: function (data) {
            if (data === true) {
                $.confirm({
                    title: 'Увага',
                    content: 'Не додано щомісячниі послиги для обраного клієнита. Якщо ви натиснете <strong>Додати</strong> то їх будо дона від вашого імені та сьогоднішнім числом.',
                    type: 'orange',
                    icon: 'fa fa-exclamation-circle',
                    typeAnimated: true,
                    buttons: {
                        confirm: {
                            btnClass: "btn-success",
                            text: "Додати",
                            action: function () {
                                location.href = `/job-log/add-monthly-job-by-client-id/${getClientId()}`;
                            }
                        },
                        cancel: {
                            text: "Відмінити",
                            action: function () {}
                        },
                    }
                });
            }else {
                location.href = `/job-log/reporting/accounting/get-added-services/${getClientId()}/${getMonth()}`;
            }
        }
    })


});

