@extends('layouts.app')
@section('title', 'Alterar Senha')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-muted">
                                <span class="svg-icon svg-icon-primary svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967
                                                                                                    12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684
                                                                                                    21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642
                                                                                                    19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368
                                                                                                    2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732
                                                                                                    3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847
                                                                                                    9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153
                                                                                                    14.5522847,13 14,13 L10,13 Z"
                                                fill="#000000" />
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="text-muted">Minhas Informações</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">

                <div class="d-flex flex-row">

                    <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">

                        <div class="card card-custom card-stretch">

                            <div class="card-body pt-4">

                                <div class="d-flex align-items-center pt-3">
                                    <div
                                        class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                        <div class="symbol-label"
                                            style="background-image:url({{ asset('assets/media/users') }}/{{ Auth::user()->image }})">
                                        </div>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name }}</a>
                                        <div class="text-muted"></div>
                                        <div class="mt-2">
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">
                                                Sair
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-9">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">E-mail:</span>
                                        <a href="#" class="text-muted text-hover-primary">{{ Auth::user()->email }}</a>
                                    </div>
                                </div>

                                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('user.personal') }}" class="navi-link py-4">
                                            <span class="navi-icon mr-2">
                                                <span class="svg-icon">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <path
                                                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                            <path
                                                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                                fill="#000000" fill-rule="nonzero" />
                                                        </g>
                                                    </svg>

                                                </span>
                                            </span>
                                            <span class="navi-text font-size-lg">Informações Pessoais</span>
                                        </a>
                                    </div>

                                    <div class="navi-item mb-2">
                                        <a href="{{ route('user.password') }}" class="navi-link py-4 active">
                                            <span class="navi-icon mr-2">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path
                                                                d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                                fill="#000000" opacity="0.3" />
                                                            <path
                                                                d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
                                                                fill="#000000" opacity="0.3" />
                                                            <path
                                                                d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                                fill="#000000" opacity="0.3" />
                                                        </g>
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="navi-text font-size-lg">Alterar Senha</span>
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="flex-row-fluid ml-lg-8">
                        <div class="card card-custom">
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">Atualizar senha</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">
                                        Atualizar senha da conta
                                    </span>
                                </div>
                                <div class="card-toolbar">
                                    <button type="reset" id="update-password" class="btn btn-success mr-2">Atualizar</button>
                                </div>
                            </div>

                            <form class="form" action="{{ route('user.password.update') }}" method="POST"
                                id="form-update-password">
                                @csrf

                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Senha atual</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" name="current_password"
                                                class="form-control form-control-lg form-control-solid mb-2" value=""
                                                placeholder="Senha atual" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Nova senha</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" name="password"
                                                class="form-control form-control-lg form-control-solid" value=""
                                                placeholder="Nova senha" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Verificar senha</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password" name="password_confirmation"
                                                class="form-control form-control-lg form-control-solid" value=""
                                                placeholder="Verificar senha" />
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        jQuery(document).ready(function() {
            KTUpdatePassword.init()
        })

    </script>
@stop
