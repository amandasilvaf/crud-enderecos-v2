var KTProfiles = function () {
    var profiles = function () {
        $('#profiles_table').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: $('#profiles_table').attr("data-source"),
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
                input: $('#profiles_table_search_query'),
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
                        <a class="btn-restore h4" href="perfis/' + e.id + '">\
                            <span class="svg-icon svg-icon-primary svg-icon-md">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                        <a class="btn-restore h4" href="permissoes/' + e.id + '">\
                            <span class="svg-icon svg-icon-primary svg-icon-md">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M6,7 C7.1045695,7 8,6.1045695 8,5 C8,3.8954305 7.1045695,3 6,3 C4.8954305,3 4,3.8954305 4,5 C4,6.1045695 4.8954305,7 6,7 Z M6,9 C3.790861,9 2,7.209139 2,5 C2,2.790861 3.790861,1 6,1 C8.209139,1 10,2.790861 10,5 C10,7.209139 8.209139,9 6,9 Z" fill="#000000" fill-rule="nonzero"/>\
                                        <path d="M7,11.4648712 L7,17 C7,18.1045695 7.8954305,19 9,19 L15,19 L15,21 L9,21 C6.790861,21 5,19.209139 5,17 L5,8 L5,7 L7,7 L7,8 C7,9.1045695 7.8954305,10 9,10 L15,10 L15,12 L9,12 C8.27142571,12 7.58834673,11.8052114 7,11.4648712 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                        <path d="M18,22 C19.1045695,22 20,21.1045695 20,20 C20,18.8954305 19.1045695,18 18,18 C16.8954305,18 16,18.8954305 16,20 C16,21.1045695 16.8954305,22 18,22 Z M18,24 C15.790861,24 14,22.209139 14,20 C14,17.790861 15.790861,16 18,16 C20.209139,16 22,17.790861 22,20 C22,22.209139 20.209139,24 18,24 Z" fill="#000000" fill-rule="nonzero"/>\
                                        <path d="M18,13 C19.1045695,13 20,12.1045695 20,11 C20,9.8954305 19.1045695,9 18,9 C16.8954305,9 16,9.8954305 16,11 C16,12.1045695 16.8954305,13 18,13 Z M18,15 C15.790861,15 14,13.209139 14,11 C14,8.790861 15.790861,7 18,7 C20.209139,7 22,8.790861 22,11 C22,13.209139 20.209139,15 18,15 Z" fill="#000000" fill-rule="nonzero"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                    '},
                }
            ],
        })

        $('#profiles_table').on('datatable-on-ajax-done', function () {
            $(function () {
                $('.status-switch').on('click', function (e, data) {
                    var id = $(this).attr('data-id')
                    var status = $(this).prop('checked')

                    if (status == true)
                        status = 'true'
                    else status = 'false'

                    $.ajax({
                        type: "PATCH",
                        url: 'perfis/' + id + '/' + status,
                        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                        statusCode: {
                            204: function () {
                                toastr.success("Situação atualizada com sucesso.")
                                $('#profiles_table').KTDatatable('reload')
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
            profiles();
        },
    };
}()
