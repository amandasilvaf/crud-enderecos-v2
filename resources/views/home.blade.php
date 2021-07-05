@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a class="text-muted">
                                Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container"></div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        jQuery(document).ready(function() {
            KTHome.init()
        })

    </script>
@stop
