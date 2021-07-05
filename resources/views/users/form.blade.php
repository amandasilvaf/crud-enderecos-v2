<div class="card card-custom gutter-b">
    <div class="card-header">
        <h3 class="card-title">
            {{ Route::currentRouteName() == 'users.new' ? 'Cadatrar Usuário' : 'Editar Usuário' }}
        </h3>
        <div class="card-toolbar">
            <a href="{{ route('users') }}" class="btn btn-primary font-weight-bolder">
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
    <form
        action="{{ Route::currentRouteName() == 'users.new' ? route('users.add') : route('users.update', $user->id) }}"
        class="form" id="new_user">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Nome:</label>
                    <input type="email" name="name" value="{{ $user->name ?? null }}" class="form-control"
                        placeholder="Nome do usuário">
                </div>
                <div class="col-lg-4">
                    <label>Email:</label>
                    <input type="email" name="email" value="{{ $user->email ?? null }}" class="form-control"
                        placeholder="Email do usuário">
                </div>
                <div class="col-lg-4">
                    <label>CPF:</label>
                    <div class="input-group">
                        <input type="text" name="cpf" value="{{ $user->cpf ?? null }}" class="form-control cpf"
                            placeholder="CPF do usuário">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Senha:</label>
                    <input type="password" autocomplete="new-password" name="password" class="form-control"
                        placeholder="********">
                </div>
                <div class="col-lg-4">
                    <label>Confirmação de senha:</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="********">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>Perfis</label>
                    <select class="form-control" id="profile_id" name="profile_id[]" multiple="multiple">
                        @foreach ($profiles as $profile)
                            <option value="{{ $profile->id }}" @if(!empty($user)) {{ $user->profiles->contains('profile_id', $profile->id) ? 'selected' : '' }}  @endif>
                                {{ $profile->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <button type="button" id="btn_submit" class="btn btn-primary mr-0">
                    {{ Route::currentRouteName() == 'users.new' ? 'Cadastrar' : 'Alterar' }}
                </button>
            </div>
        </div>
    </form>
</div>
