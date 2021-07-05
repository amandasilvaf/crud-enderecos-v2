var KTUserCreate = function () {
    $('.cpf').mask('000.000.000-00')
    $('#profile_id').select2({
        multiple: true,
        placeholder: 'Selecione um perfil'
    })

    var _handleRegisterForm = function () {
        var validation;

        validation = FormValidation.formValidation(
            KTUtil.getById('new_user'),
            {
                fields: {
                    cpf: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um cpf'
                            }
                        }
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um nome'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um e-mail'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar uma senha'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar a confirmação de senha'
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
        );

        $('#btn_submit').on('click', function (e) {
            e.preventDefault();
            var form = KTUtil.getById('new_user');
            var formSubmitUrl = KTUtil.attr(form, 'action');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    $('#new_user').ajaxSubmit({
                        url: formSubmitUrl,
                        method: 'POST',
                        dataType: 'json',
                        statusCode: {
                            201: function (resposta) {
                                toastr.success('Usuário cadastrado com sucesso.')
                                setTimeout(function () {
                                    location.reload(true)
                                }, 1500)
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
            });
        });
    }

    return {
        init: function () {
            _handleRegisterForm()
        }
    };
}()
