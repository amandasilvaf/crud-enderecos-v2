var KTSubmenuCreate = function () {
    var _handleSubmenuForm = function () {
        var validation;
        $('#menu_id').select2({placeholder: "Selecione um menu"})
        $('#sub_menu_id').select2({placeholder: "Selecione um submenu"})

        validation = FormValidation.formValidation(
            KTUtil.getById('new_submenu'),
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa informar um nome'
                            }
                        }
                    },
                    menu_id: {
                        validators: {
                            notEmpty: {
                                message: 'Você precisa selecionar um menu'
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
            var form = KTUtil.getById('new_submenu');
            var formSubmitUrl = KTUtil.attr(form, 'action');
            var formSubmitButton = KTUtil.getById('btn_submit');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    FormValidation.utils.fetch(formSubmitUrl, {
                        method: 'POST',
                        dataType: 'json',
                        params: {
                            name: form.querySelector('[name="name"]').value,
                            menu_id: form.querySelector('[name="menu_id"]').value,
                            sub_menu_id: form.querySelector('[name="sub_menu_id"]').value,
                            route: form.querySelector('[name="route"]').value,
                            icon: form.querySelector('[name="icon"]').value,
                            _token: form.querySelector('[name="_token"]').value,
                        },
                    }).then(function (response) {
                        KTUtil.btnRelease(formSubmitButton);
                        if (response.result === 'success') {
                            toastr.success('Submenu cadastrado com sucesso.')
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
            _handleSubmenuForm()
        }
    };
}()
