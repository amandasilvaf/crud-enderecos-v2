"use strict"

var KTUpdateInfo = function () {
    var updateInfo = function () {
        $('#btn_submit').click(function (e) {
            e.preventDefault()

            var btn = $(this)
            var form = $('#kt-form')

            form.validate({
                rules: {
                    nome: {
                        required: true
                    },
                    email: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            KTApp.progress(btn[0])

            form.ajaxSubmit({
                url: '/perfil',
                method: 'PUT',
                statusCode: {
                    204: function () {
                        KTApp.unprogress(btn[0])
                        toastr.success("Informações atualizadas com sucesso.")
                    },
                    400: function (response) {
                        KTApp.unprogress(btn[0])
                        jQuery.each(JSON.parse(response.responseText), function (key, value) {
                            toastr.error(value)
                        })
                    },
                    500: function () {
                        KTApp.unprogress(btn[0])
                        toastr.error('Ocorreu um erro no Servidor.')
                    }
                }
            });
        });
    }

    return {
        init: function () {
            updateInfo()
        }
    };
}()
