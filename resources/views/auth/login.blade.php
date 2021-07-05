@extends('auth.default')

@section('css')
    <link href="{{ asset('assets/css/pages/login/classic/login-4.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="d-flex flex-column flex-root">
        <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
                style="background-image: url('assets/media/bg/bg-3.jpg');">
                <div class="login-form text-center p-7 position-relative overflow-hidden">
                    <div class="d-flex flex-center mb-15">
                        <a href="{{ route('login') }}">
                            <img src="{{ asset('assets/media/logos/ecode-p.svg') }}" class="max-h-75px" />
                        </a>
                    </div>

                    <div class="login-signin">
                        <div class="mb-20">
                            <h3>Painel - Laravel Base</h3>
                            <div class="text-muted font-weight-bold">Utilize suas credenciais para acessar:</div>
                        </div>
                        <form class="form" action="{{ route('user.login') }}" class="form" novalidate="novalidate"
                            id="kt_login_signin_form">
                            @csrf
                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8 cpf" type="text"
                                    placeholder="000.000.000-00" name="cpf" value="{{ old('cpf') }}" autocomplete="off" />
                            </div>
                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8" placeholder="*********"
                                    type="password" name="password" autocomplete="off" />
                            </div>
                            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                                <div class="checkbox-inline"></div>
                                <a type="button" id="kt_login_forgot" class="text-muted text-hover-primary">
                                    Esqueceu sua senha?
                                </a>
                            </div>
                            <button id="kt_login_signin_submit" data-url="{{ url()->previous() }}"
                                class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Entrar</button>
                        </form>
                    </div>

                    <div class="login-forgot">
                        <div class="mb-20">
                            <h3>Esqueceu sua senha?</h3>
                            <div class="text-muted font-weight-bold">Digite seu CPF abaixo para continuar</div>
                        </div>
                        <form action="{{ route('user.password.recovery') }}" class="form" novalidate="novalidate"
                            id="kt_login_forgot_form">
                            @csrf
                            <div class="form-group mb-10">
                                <input class="form-control form-control-solid h-auto py-4 px-8 cpf"
                                type="text" placeholder="000.000.000-00" name="cpf" autocomplete="off" />
                            </div>
                            <div class="form-group d-flex flex-wrap flex-center mt-10">
                                <button id="kt_login_forgot_submit"
                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Enviar</button>
                                <button id="kt_login_forgot_cancel"
                                    class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        jQuery(document).ready(function() {
            KTLogin.init()
        })

    </script>
@endsection
