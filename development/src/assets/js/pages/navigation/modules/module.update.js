var KTModuleUpdate = function () {
    var _handleModuleForm = function () {
        var validation;

        validation = FormValidation.formValidation(
            KTUtil.getById('new_module'),
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um nome'
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
            var form = KTUtil.getById('new_module');
            var formSubmitUrl = KTUtil.attr(form, 'action');
            var formSubmitButton = KTUtil.getById('btn_submit');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    FormValidation.utils.fetch(formSubmitUrl, {
                        method: 'POST',
                        dataType: 'json',
                        params: {
                            name: form.querySelector('[name="name"]').value,
                            _token: form.querySelector('[name="_token"]').value,
                        },
                    }).then(function (response) {
                        KTUtil.btnRelease(formSubmitButton);
                        if (response.result === 'success') {
                            toastr.success('Módulo alterado com sucesso.')
                            setTimeout(function () {
                                location.reload(true)
                            }, 1500)
                        } else {
                            jQuery.each(response, function (key, value) {
                                toastr.error(value)
                            })
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
            _handleModuleForm()
        }
    };
}()
