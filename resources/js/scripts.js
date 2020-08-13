
const dataTableLanguageOptions = {
    paginate: {
        previous: '<i class="fa fa-arrow-left"> </i>',
        next:     '<i class="fa fa-arrow-right"> </i>',
    },
    zeroRecords: "Немає записів для відображення!",
    info: "Показано сторінок _PAGE_ з _PAGES_",
    lengthMenu: "Відобразити _MENU_ записів.",
    search: "Пошук:",
};

const datePickerLocaleOptions = {
    format: "Y-MM-DD H:mm:ss",
    applyLabel: "Підтвердити",
    cancelLabel: "Відмінити",
    monthNames: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
    daysOfWeek: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
    firstDay: 1
};


module.exports = {
    getDataTableLanguageOptions() {
        return dataTableLanguageOptions;
    },

    getDatePickerLocaleOptions() {
        return datePickerLocaleOptions;
    },

    /**
     * @param id_table
     * @param order
     */
    showDataTable (id_table) {

        let options = {
            language: dataTableLanguageOptions,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            pageLength: 25,
            lengthMenu: ["25", "50", "100", "200", "All",],
        };

        return $(id_table).DataTable(options);
    },

    //Date range picker
    showDateRangePicker(id_input) {
        let options = {
            locale:datePickerLocaleOptions,
        };

        return $(id_input).daterangepicker(options);
    },

    showDatePicker(id_input) {
        let options = {
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 30,
            locale:datePickerLocaleOptions,
        };

        return $(id_input).daterangepicker(options);
    },

    confirmDeleteItemByHref(href, title = 'Увага', content = 'Ви впевненні що хочете видалити цей елемент?', confirmText = "Видалити") {
        $.confirm({
            title: title,
            content: content,
            type: 'red',
            icon: 'fa fa-exclamation-circle',
            typeAnimated: true,
            buttons: {
                confirm: {
                    btnClass: "btn-danger",
                    text: confirmText,
                    action: function () {
                        location.href = href
                    }
                },
                cancel: {
                    text: "Відмінити",
                    action: function () {}
                },
            }
        });
    }

};
