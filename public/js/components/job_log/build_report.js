$(function () {
    $(".select2").select2();
    $('.duallistbox').bootstrapDualListbox();
    scripts.showDateRangePicker("#data_time_between")
});

$(".btnGroupReportForBuh .dropdown-menu .dropdown-item").click(function () {
    $(".btnGroupReportForBuh .dropdown-menu .dropdown-item")
        .removeAttr("data-selected")
        .removeClass("bg-warning");

    $(this)
        .attr("data-selected", "true")
        .addClass("bg-warning");
});
