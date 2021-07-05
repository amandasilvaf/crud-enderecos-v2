var KTUsers = function () {
    var users = function () {
        $('#users_table').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: $('#users_table').attr("data-source"),
                        method: "GET",
                        map: function (raw) {
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },
            layout: {
                scroll: false,
                footer: false,
            },
            sortable: true,

            pagination: true,

            search: {
                input: $('#users_table_search_query'),
                key: 'generalSearch'
            },

            rows: {
                afterTemplate: function () {
                    $('.cpf').mask('000.000.000-00')
                },
            },

            columns: [
                {
                    field: 'name',
                    title: 'Nome',
                    type: 'text',
                    selector: false
                },
                {
                    field: 'cpf',
                    title: 'CPF',
                    type: 'text',
                    selector: false,
                    template: function (row) {
                        return '\
                            <span class="cpf">'+ row.cpf + '</span>\
                        ';
                    }
                },
                {
                    field: 'email',
                    title: 'E-mail',
                    type: 'text',
                    selector: false
                },
                {
                    field: 'status',
                    title: 'Situação',
                    template: function (row) {
                        var status = {
                            true: { 'checked': 'checked' },
                            false: { 'checked': 'unchecked' },
                        }
                        return '\
                        <div class="col-3">\
                            <span class="switch switch-sm switch-outline switch-icon switch-success">\
                                <label>\
                                    <input name="status" class="status-switch" data-id=' + row.id + ' data-status=' + row.status + ' type="checkbox" ' + status[row.status].checked + '>\
                                    <span></span>\
                                </label>\
                            </span>\
                        </div>';
                    },
                },
                {
                    field: 'Actions',
                    title: 'Ações',
                    sortable: false,
                    textAlign: 'center',
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    template: function (e) {
                        return '\
                        <a class="btn-restore h4" href="usuarios/' + e.id + '">\
                            <span class="svg-icon svg-icon-primary svg-icon-2x">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                    '},
                }
            ],
        })

        $('#users_table').on('datatable-on-ajax-done', function () {
            $(function () {
                $('.status-switch').on('click', function (e, data) {
                    var id = $(this).attr('data-id')
                    var status = $(this).prop('checked')

                    if (status == true)
                        status = 'true'
                    else status = 'false'

                    $.ajax({
                        type: "PATCH",
                        url: 'usuarios/' + id + '/' + status,
                        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                        statusCode: {
                            204: function () {
                                toastr.success("Situação atualizada com sucesso.")
                                $('#users_table').KTDatatable('reload')
                            },
                            400: function (response) {
                                jQuery.each(JSON.parse(response.responseText), function (key, value) {
                                    toastr.error(value)
                                })
                            },
                            500: function () {
                                toastr.error('Ocorreu um erro no Servidor.')
                            }
                        }
                    })
                })
            })
        })
    }

    return {
        init: function () {
            users();
        },
    };
}()
