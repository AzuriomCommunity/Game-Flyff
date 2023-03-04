@extends('layouts.app')

@section('title', 'Flyff Accounts')

@section('content') 
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Account Name</th>
                            <th scope="col">Role</th>
                            <th scope="col"># of characters</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->accounts as $item)
                            <tr>
                                <td>{{$item->account}}</td>
                                <td>{{$item->member}}</td>
                                <td>{{$item->characters()->count()}}</td>
                                <td>
                                    <a href="{{route('flyff.accounts.edit', $item)}}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">Create a game account</div>
                    <div class="card-body">
                        <form action="{{route('flyff.accounts.store')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="create_account_name" class="form-label">Account Name</label>
                                <input type="text" name="account" class="form-control @error('account') is-invalid @enderror" id="create_account_name">
                                @error('account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="create_account_password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="create_account_password">
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

            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">Link an old account</div>
                    <div class="card-body">
                        <form action="{{route('flyff.accounts.link')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="link_account_name" class="form-label">Account Name</label>
                                <input type="text" name="account_link" class="form-control @error('account_link') is-invalid @enderror" id="link_account_name">
                                @error('account_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="link_account_password" class="form-label">Password</label>
                                <input type="password" name="password_link" class="form-control @error('password_link') is-invalid @enderror" id="link_account_password">
                                @error('password_link')
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
