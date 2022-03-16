@extends('install.layout')

@section('content')
<form method="POST" action="{{route('flyff.install.storeAdminAccount')}}">
    @csrf

    <h3>{{ trans('install.game.user.title') }}</h3>

    <div class="form-group">
        <label for="name" class="form-label">{{ trans('install.game.user.name') }}</label>

        <input name="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" autocomplete="name" required value="{{ old('name', '') }}">

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email" class="form-label">{{ trans('install.game.user.email') }}</label>

        <input name="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required value="{{ old('email', '') }}">

        @error('email')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password" class="form-label">{{ trans('install.game.user.password') }}</label>

        <input name="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" required>

        @error('password')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password-confirm" class="form-label">{{ trans('install.game.user.password_confirm') }}</label>

        <input name="password_confirmation" id="password-confirm" type="password" class="form-control" autocomplete="new-password" required>
    </div>

    <small class="form-text text-danger mb-3">{{ trans('install.game.warn') }}</small>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">
            {{ trans('install.game.install') }} <i class="bi bi-check-lg"></i>
        </button>
    </div>
</form>
@endsection
