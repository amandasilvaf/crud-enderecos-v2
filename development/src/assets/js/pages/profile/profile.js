var KTProfile = function () {
    var avatar
    var offcanvas

    var _updatePersonalInfo = function () {

        $(".cpf").mask("999.999.999-99")

        var validation

        validation = FormValidation.formValidation(
            KTUtil.getById('form-personal-info'),
            {
                fields: {
                    cpf: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um CPF'
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

        $('#update-personal-info').on('click', function (e) {
            e.preventDefault()
            var form = KTUtil.getById('form-personal-info')
            var formSubmitUrl = KTUtil.attr(form, 'action')

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    $('#form-personal-info').ajaxSubmit({
                        url: formSubmitUrl,
                        method: 'POST',
                        statusCode: {
                            204: function (e) {
                                toastr.success("Cadastro atualizado com sucesso.")
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

    var _initAside = function () {
        offcanvas = new KTOffcanvas('kt_profile_aside', {
            overlay: true,
            baseClass: 'offcanvas-mobile',
            toggleBy: 'kt_subheader_mobile_toggle'
        })
    }

    var _initForm = function () {
        avatar = new KTImageInput('kt_profile_avatar')
    }

    return {
        init: function () {
            _initAside()
            _initForm()
            _updatePersonalInfo()
        }
    };
}()
