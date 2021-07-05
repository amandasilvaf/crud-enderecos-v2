<div class="card card-custom gutter-b">
    <div class="card-header">
        <h3 class="card-title">
            {{ Route::currentRouteName() == 'submenus.new' ?  'Cadatrar Submenu' : 'Editar Submenu' }}
        </h3>
        <div class="card-toolbar">
            <a href="{{ route('submenus') }}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) " />
                        </g>
                    </svg>
                </span>Voltar</a>
        </div>
    </div>
    <form action="{{ Route::currentRouteName() == 'submenus.new' ? route('submenus.add') : route('submenus.update', $submenu->id)   }}" class="form" id="new_submenu">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <div class="col-12 col-md-3">
                    <label>Nome:</label>
                    <input type="text" name="name" value="{{ $submenu->name ?? null }}" class="form-control" placeholder="Nome do menu">
                </div>
                <div class="col-12 col-md-2">
                    <label>Menu:</label>
                    <select class="form-control" name="menu_id" id="menu_id">
                        <option value=""></option>
                        @foreach ($menus as $item)
                            <option value="{{ $item->id }}" @if(!empty($submenu)){{ $submenu->menu_id === $item->id ? 'selected' : '' }}@endif> {{ $item->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label>Submenu:</label>
                    <select class="form-control" name="sub_menu_id" id="sub_menu_id">
                        <option value=""></option>
                        @foreach ($submenus as $item)
                            @if(!empty($submenu))
                                @if($submenu->id != $item->id)
                                    <option value="{{ $item->id }}" @if(!empty($submenu)){{ $submenu->sub_menu_id === $item->id ? 'selected' : '' }}@endif> {{ $item->name }} </option>
                                @endif
                            @else
                                <option value="{{ $item->id }}" @if(!empty($submenu)){{ $submenu->sub_menu_id === $item->id ? 'selected' : '' }}@endif> {{ $item->name }} </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label>Rota:</label>
                    <input type="text" name="route" value="{{ $submenu->route ?? null }}" class="form-control" placeholder="Nome da rota">
                </div>
                <div class="col-12 col-md-2">
                    <label>Icone:</label>
                    <input type="text" name="icon" value="{{ $submenu->icon ?? null }}" class="form-control" placeholder="ícone">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <button type="button" id="btn_submit" class="btn btn-primary mr-0">
                    {{ Route::currentRouteName() == 'submenus.new' ?  'Cadastrar' : 'Alterar'  }}
                </button>
            </div>
        </div>
    </form>
</div>
