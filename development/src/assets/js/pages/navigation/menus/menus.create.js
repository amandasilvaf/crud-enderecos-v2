var KTMenuCreate = function () {
    var _handleMenuForm = function () {
        var validation;
        $('#module_id').select2({placeholder: "Selecione um módulo"})

        validation = FormValidation.formValidation(
            KTUtil.getById('new_menu'),
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um nome'
                            }
                        }
                    },
                    module_id: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um módulo'
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
            var form = KTUtil.getById('new_menu');
            var formSubmitUrl = KTUtil.attr(form, 'action');
            var formSubmitButton = KTUtil.getById('btn_submit');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    FormValidation.utils.fetch(formSubmitUrl, {
                        method: 'POST',
                        dataType: 'json',
                        params: {
                            name: form.querySelector('[name="name"]').value,
                            module_id: form.querySelector('[name="module_id"]').value,
                            route: form.querySelector('[name="route"]').value,
                            icon: form.querySelector('[name="icon"]').value,
                            _token: form.querySelector('[name="_token"]').value,
                        },
                    }).then(function (response) {
                        KTUtil.btnRelease(formSubmitButton);
                        if (response.result === 'success') {
                            toastr.success('Menu cadastrado com sucesso.')
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
            _handleMenuForm()
        }
    };
}()
