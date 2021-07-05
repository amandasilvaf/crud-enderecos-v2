var KTRecovery = function () {
    $('.cpf').mask('000.000.000-00');

    var _handleResetForm = function (e) {
        var validation;

        validation = FormValidation.formValidation(
            KTUtil.getById('kt_login_reset_form'),
            {
                fields: {
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
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        $('#kt_login_reset_submit').on('click', function (e) {
            e.preventDefault();
            var form = KTUtil.getById('kt_login_reset_form');
            var formSubmitUrl = KTUtil.attr(form, 'action');
            var formRedirectUrl = KTUtil.attr(form, 'login');
            var formSubmitButton = KTUtil.getById('kt_login_reset_submit');
            var _spinnerClass = 'spinner spinner-white spinner-right';

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    $('#kt_login_reset_submit').addClass(_spinnerClass);
                    FormValidation.utils.fetch(formSubmitUrl, {
                        method: 'POST',
                        dataType: 'json',
                        params: {
                            password: form.querySelector('[name="password"]').value,
                            password_confirmation: form.querySelector('[name="password_confirmation"]').value,
                            token: form.querySelector('[name="token"]').value,
                            _token: form.querySelector('[name="_token"]').value,
                        },
                    }).then(function (response) {
                        KTUtil.btnRelease(formSubmitButton);
                        if (response.result === 'success') {
                            toastr.success('Senha alterada com sucesso')
                            setTimeout(function () {
                                $(location).attr('href', formRedirectUrl)
                            }, 2500)
                        } else {
                            toastr.error(response)
                        }
                    });
                } else {
                    toastr.error('Por favor verifique os campos obrigatórios.')
                }
            });
        });
    }

    return {
        init: function () {
            _handleResetForm();
        }
    };
}()
