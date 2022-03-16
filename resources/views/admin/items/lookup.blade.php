@extends('admin.layouts.admin')

@section('title', trans('admin.users.title'))

@section('content')

<div class="alert alert-info" role="alert">
    Both are required : Item ID, quantity
</div>

    <form class="form-inline mb-3" action="{{ route('flyff.admin.lookup') }}" method="GET">
        <div class="form-group mb-2">
            <label for="searchInput" class="sr-only">{{ trans('messages.actions.search') }}</label>

            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" name="itemID" value="{{ $itemID ?? '' }}" placeholder="itemID">
                <input type="text" class="form-control" id="searchInput" name="min" value="{{ $min ?? '' }}" placeholder="min value">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h3>Characters</h3>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">INVENTORY_TBL</th>
                        <th scope="col">tblPocket</th>
                        <th scope="col">BANK_TBL</th>
                        <th scope="col">MAIL_TBL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['characters'] as $name => $character)
                    <tr>
                        <td>{{$name}}</td>
                        <td>{{$character['m_Inventory'] ?? '0'}}</td>
                        <td>{{$character['szItem'] ?? '0'}}</td>
                        <td>{{$character['m_Bank'] ?? '0'}}</td>
                        <td>{{$character['nItemNum'] ?? '0'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>Guilds</h3>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">GUILD_BANK_TBL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['guilds'] as $name => $quantity)
                    <tr>
                        <td>{{$name}}</td>
                        <td>{{$quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection