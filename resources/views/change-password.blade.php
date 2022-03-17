@extends('layouts.app')

@section('title', 'Plugin home')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('auth.passwords.reset') }}</div>
    
                    <div class="card-body">
                        <form action="{{route('flyff.accounts.change-password', $account)}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="account_name" class="form-label">Account Name</label>
                                <input type="text" name="account" class="form-control" disabled value="{{$account->account}}" id="account_name">
                            </div>
                            <div class="mb-3">
                                <label for="account_password" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="account_password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm">{{ trans('auth.confirm-password') }}</label>
                                <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection