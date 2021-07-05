var KTLogin = function () {
    var _login
    $('.cpf').mask('000.000.000-00')

    var _showForm = function (form) {
        var cls = 'login-' + form + '-on'
        var form = 'kt_login_' + form + '_form'

        _login.removeClass('login-forgot-on')
        _login.removeClass('login-signin-on')
        _login.addClass(cls)

        KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp')
    }

    var _handleSignInForm = function () {
        $('#kt_login_signin_submit').on('click', function (e) {
            e.preventDefault()

            var btn = KTUtil.getById("kt_login_signin_submit")
            KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Aguarde")

            var form = KTUtil.getById('kt_login_signin_form')
            var formSubmitUrl = KTUtil.attr(form, 'action')
            var redirectAfterLogin = $('#kt_login_signin_submit').data('url')

            $('#kt_login_signin_form').ajaxSubmit({
                url: formSubmitUrl,
                method: 'POST',
                statusCode: {
                    200: function (response) {
                        localStorage.setItem("logged-user", response.cpf)
                        KTUtil.btnRelease(btn)
                        $(location).attr('href', redirectAfterLogin)
                    },
                    400: function (response) {
                        KTUtil.btnRelease(btn)
                        jQuery.each(JSON.parse(response.responseText), function (key, value) {
                            toastr.error(value)
                        })
                    },
                    500: function () {
                        KTUtil.btnRelease(btn)
                        toastr.error('Ocorreu um erro no Servidor.')
                    }
                }
            })
        })

        $('#kt_login_forgot').on('click', function (e) {
            e.preventDefault()
            _showForm('forgot')
        })
    }

    var _handleForgotForm = function () {
        $('#kt_login_forgot_submit').on('click', function (e) {
            e.preventDefault()

            var btn = KTUtil.getById("kt_login_forgot_submit")
            KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Aguarde")

            var form = KTUtil.getById('kt_login_forgot_form')
            var formSubmitUrl = KTUtil.attr(form, 'action')

            $('#kt_login_forgot_form').ajaxSubmit({
                url: formSubmitUrl,
                method: 'POST',
                statusCode: {
                    200: function () {
                        KTUtil.btnRelease(btn)
                        toastr.success('Enviamos um email com instruções para recuperar sua senha.')
                        _showForm('signin')
                    },
                    400: function (response) {
                        KTUtil.btnRelease(btn)
                        jQuery.each(JSON.parse(response.responseText), function (key, value) {
                            toastr.error(value)
                        })
                    },
                    500: function () {
                        KTUtil.btnRelease(btn)
                        toastr.error('Ocorreu um erro no Servidor.')
                    }
                }
            })
        })

        $('#kt_login_forgot_cancel').on('click', function (e) {
            e.preventDefault()
            _showForm('signin')
        })
    }

    return {
        init: function () {
            _login = $('#kt_login')

            _handleSignInForm()
            _handleForgotForm()
        }
    };
}()