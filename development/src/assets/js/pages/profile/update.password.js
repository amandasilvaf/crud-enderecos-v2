var KTUpdatePassword = function () {

    var _updatePassword = function () {

        var validation

        validation = FormValidation.formValidation(
            KTUtil.getById('form-update-password'),
            {
                fields: {
                    current_password: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um CPF'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um nome'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um email'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        )

        $('#update-password').on('click', function (e) {
            e.preventDefault()
            var form = KTUtil.getById('form-update-password')
            var formSubmitUrl = KTUtil.attr(form, 'action')

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    $('#form-update-password').ajaxSubmit({
                        url: formSubmitUrl,
                        method: 'POST',
                        statusCode: {
                            204: function (e) {
                                toastr.success("Senha atualizada com sucesso.")
                                setTimeout(function () {
                                    location.reload(true)
                                }, 800)
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
                } else {
                    toastr.error('Por favor verifique os campos obrigatórios.')
                }
            })
        })
    }

    return {
        init: function () {
            _updatePassword()
        }
    };
}()
