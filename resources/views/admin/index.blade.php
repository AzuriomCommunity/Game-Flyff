@extends('admin.layouts.admin')

@section('title', trans('admin.users.title'))

@section('content')
    <form class="form-inline mb-3" action="{{ route('flyff.admin.index') }}" method="GET">
        <div class="mb-3 mb-2">
            <label for="searchInput" class="sr-only">{{ trans('messages.actions.search') }}</label>

            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}" placeholder="{{ trans('messages.actions.search') }}">

                
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('auth.name') }}</th>
                        <th scope="col">{{ oauth_login() ? game()->trans('id') : trans('auth.email') }}</th>
                        <th scope="col">{{ trans('messages.fields.role') }}</th>
                        <th scope="col">{{ trans('admin.users.fields.register-date') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr>
                            <th scope="row">
                                {{ $user->id }}

                                @if($user->is_deleted)
                                    <i class="bi bi-person-x text-dark" title="{{ trans('admin.users.info.deleted') }}" data-toggle="tooltip"></i>
                                @elseif($user->isAdmin())
                                    <i class="bi bi-trophy text-warning" title="{{ trans('admin.users.info.admin') }}" data-toggle="tooltip"></i>
                                @endif
                                @if($user->is_banned)
                                    <i class="bi bi-slash-circle text-danger" title="{{ trans('admin.users.info.banned') }}" data-toggle="tooltip"></i>
                                @endif
                            </th>
                            <td @if($user->is_deleted) class="text-strikethrough" @endif>
                                {{ $user->name }}
                            </td>
                            <td @if($user->is_deleted) class="text-strikethrough" @endif>
                                {{ oauth_login() ? ($user->game_id ?? trans('messages.unknown')) : $user->email }}
                            </td>
                            <td>
                                <span class="badge badge-label" style="{{ $user->role->getBadgeStyle() }}">
                                    {{ $user->role->name }}
                                </span>
                            </td>
                            <td>
                                {{ format_date($user->created_at) }}
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                <a class="mx-1" data-toggle="collapse" href="#collapse-{{$user->id}}" role="button" aria-expanded="false" aria-controls="collapse-{{$user->id}}"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        <tr class="collapse" id="collapse-{{$user->id}}">
                            <td></td>
                            <td colspan="5">
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
                                                <td><a href="{{ route('admin.users.edit', $user) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i class="bi bi-pencil-square"></i></a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>        
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            {{ $users->withQueryString()->links() }}

            <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
