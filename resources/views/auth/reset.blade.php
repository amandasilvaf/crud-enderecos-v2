@extends('auth.default')

@section('css')
<link href="{{ asset('assets/css/pages/login/login-1.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="d-flex flex-column flex-root">
    <div class="login login-1 login-reset-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #F2C98A;">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <a href="{{ route('login') }}" class="text-center mb-10">
                    <img src="{{ asset('assets/media/logos/ecode-p.svg') }}" class="max-h-120px" />
                </a>
            </div>
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style='background-image: url({{ asset("assets/media/svg/illustrations/login-visual-1.svg") }})'></div>
        </div>

        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex flex-column-fluid flex-center">
                <div class="login-form login-reset">
                <form action="{{ route('user.password.reset') }}" login="{{ route('login') }}" class="form" novalidate="novalidate" id="kt_login_reset_form">
                        @csrf
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Informe sua nova senha</h3>
                        </div>
                        <input type="hidden" name="token" value="{{ Request::route('token') }}">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Nova Senha</label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" placeholder="*********" type="password" name="password" autocomplete="off" />
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Confirmação de Senha</label>
                            </div>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" placeholder="*********" type="password" name="password_confirmation" autocomplete="off" />
                        </div>

                        <div class="pb-lg-0 pb-5">
                            <button type="button" id="kt_login_reset_submit" class="btn btn-primary float-right font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                <span>Desenvolvido por:
                    <a target="_blank" href="https://www.agenciaecode.com.br/" class="text-primary font-weight-bolder font-size-h5">
                        <img src="{{ asset('assets/media/logos/ecode-p.svg') }}" class="max-h-15px" style="margin-top:-4px;" />
                    </a>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    jQuery(document).ready(function () {
        KTRecovery.init()
    })
</script>
@endsection
