@extends('admin.layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">     
        <form action="{{ route('flyff.admin.settings_update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="sqlsrv_host" class="form-label">SQL Server Host</label>
                <input type="text" class="form-control @error('sqlsrv_host') is-invalid @enderror" id="sqlsrv_host" name="sqlsrv_host" placeholder="DESKTOP-XXX/SQLSERVER" value="{{ old('sqlsrv_host', setting('flyff.sqlsrv_host')) }}">

                @error('sqlsrv_host')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror

            </div>

            <div class="mb-3">
                <label for="sqlsrv_port" class="form-label">SQL Server Port</label>
                <input type="text" class="form-control @error('sqlsrv_port') is-invalid @enderror" id="sqlsrv_port" name="sqlsrv_port" value="{{ old('sqlsrv_port', setting('flyff.sqlsrv_port')) }}" aria-describedby="sqlsrv_port_info">

                @error('sqlsrv_port')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <small id="sqlsrv_port_info" class="form-text">Most of the time SQL Server doesn't have a port, you can leave it blank</small>
            </div>

            <div class="mb-3">
                <label for="sqlsrv_username" class="form-label">SQL Server Username</label>
                <input type="text" class="form-control @error('sqlsrv_username') is-invalid @enderror" id="sqlsrv_username" name="sqlsrv_username" placeholder="MyNewAdminUser" value="{{ old('sqlsrv_username', setting('flyff.sqlsrv_username')) }}" aria-describedby="sqlsrv_username_info">

                @error('sqlsrv_username')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <small id="sqlsrv_username_info" class="form-text">For security reasons, please do not use the default <code>MyNewAdminUser</code> , create your own with the script!</small>
            </div>

            <div class="mb-3">
                <label for="sqlsrv_password" class="form-label">SQL Server Password</label>
                <input type="text" class="form-control @error('sqlsrv_password') is-invalid @enderror" id="sqlsrv_password" name="sqlsrv_password" value="{{ old('sqlsrv_password', setting('flyff.sqlsrv_password')) }}"  aria-describedby="sqlsrv_password_info">

                @error('sqlsrv_password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <small id="sqlsrv_password_info" class="form-text">For security reasons, please do not use <code>abcd</code> as a password!</small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>

    </div>
</div>
@endsection