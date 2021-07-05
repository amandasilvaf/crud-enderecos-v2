"use strict"

var KTUsersTrash = function () {
    var usersTrash = function () {
        var options = {
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/usuarios/lixeira/list',
                        method: 'GET',
                    },
                },
                pageSize: 10,
                serverPaging: false,
                serverFiltering: false,
                serverSorting: false,
            },
            layout: {
                scroll: true,
                footer: false,
            },
            sortable: true,
            pagination: true,
            search: {
                input: $('#generalSearch'),
            },
            columns: [
                {
                    field: 'nome',
                    title: 'Nome',
                }, {
                    field: 'email',
                    title: 'E-mail'
                }, {
                    field: 'deleted_at',
                    title: 'Exclusão',
                    template: function (e) {
                        var data = e.deleted_at;
                        return (data.substr(0, 10).split('-').reverse().join('/'));
                    },
                }, {
                    field: 'Actions',
                    title: 'Restaurar',
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    template: function (e) {
                        return '\
                            <a class="btn-restore h4" id=' + e.id + '><i class="la la-refresh restore text-center" id=' + e.id + '></i></a>\
					'
                    },
                }
            ],
        }

        var datatable = $('.kt-datatable').KTDatatable(options)

        datatable.on('click', function (dt) {
            let id = dt.target.id
            if ((typeof dt.target.classList[2] != "undefined") &&
                (dt.target.classList[2] == 'restore')) {

                $.ajax({
                    type: "patch",
                    url: '/usuarios/lixeira/' + id,
                    statusCode: {
                        204: function () {
                            toastr.success("Cadastro restaurado com sucesso.")
                            $('.kt-datatable').KTDatatable('reload')
                        },
                        400: function (response) {
                            jQuery.each(JSON.parse(response.responseText), function (key, value) {
                                toastr.error(value)
                            })
                        },
                        500: function () {
                            KTApp.unprogress(btn[0])
                            toastr.error('Ocorreu um erro no Servidor.')
                        }
                    }
                })
            }
        })

    }

    return {
        init: function () {
            usersTrash()
        },
    }
}();