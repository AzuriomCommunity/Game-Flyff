@extends('install.layout')

@section('content')
<p>If you don't have a SQLServer <code>username/password</code> please <a target="_blank" href="https://github.com/AzuriomCommunity/Game-Flyff/wiki/Installation#database">follow this link (click me)</a></p>
<form action="{{route('flyff.install.setupDatabase')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="sqlsrv_host">SQL Server Host</label>
        <input type="text" class="form-control @error('sqlsrv_host') is-invalid @enderror" id="sqlsrv_host" name="sqlsrv_host" placeholder="DESKTOP-XXX/SQLSERVER or IP address" value="{{ old('sqlsrv_host', setting('flyff.sqlsrv_host')) }}">

        @error('sqlsrv_host')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror

    </div>

    <div class="form-group">
        <label for="sqlsrv_port">SQL Server Port</label>
        <input type="text" class="form-control @error('sqlsrv_port') is-invalid @enderror" id="sqlsrv_port" name="sqlsrv_port" value="{{ old('sqlsrv_port', setting('flyff.sqlsrv_port')) }}" aria-describedby="sqlsrv_port_info">

        @error('sqlsrv_port')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <small id="sqlsrv_port_info" class="form-text">If you use <code>DESKTOP-XXX</code> leave the port empty, otherwise the default port is <code>1443</code> </small>
    </div>

    <div class="form-group">
        <label for="sqlsrv_username">SQL Server Username</label>
        <input type="text" class="form-control @error('sqlsrv_username') is-invalid @enderror" id="sqlsrv_username" name="sqlsrv_username" placeholder="MyNewAdminUser" value="{{ old('sqlsrv_username', setting('flyff.sqlsrv_username')) }}" aria-describedby="sqlsrv_username_info">

        @error('sqlsrv_username')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <small id="sqlsrv_username_info" class="form-text">For security reasons, please do not use the default <code>MyNewAdminUser</code> , create your own with <a target="_blank" href="https://github.com/AzuriomCommunity/Game-Flyff/wiki/Installation#database">the script here!</a> </small>
    </div>

    <div class="form-group">
        <label for="sqlsrv_password">SQL Server Password</label>
        <input type="text" class="form-control @error('sqlsrv_password') is-invalid @enderror" id="sqlsrv_password" name="sqlsrv_password" value="{{ old('sqlsrv_password', setting('flyff.sqlsrv_password')) }}"  aria-describedby="sqlsrv_password_info">

        @error('sqlsrv_password')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <small id="sqlsrv_password_info" class="form-text">For security reasons, please do not use <code>abcd</code> as a password!</small>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
    </button>
</form>
@endsection
