@extends('admin.layouts.admin')



@section('title', 'Guild Siege')

@section('content')

@include('admin.elements.date-picker')

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{route('flyff.admin.addSiege')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-3">
                <div class="custom-file">
                  <input name="siege_log" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <div class="form-group">
                <label for="publishedInput">When the guild siege happened?</label>
                <input type="text" class="form-control date-picker @error('happened_at') is-invalid @enderror" id="publishedInput" name="happened_at" value="{{ old('happened_at', $guildSiege->happened_at ?? now()) }}" required aria-describedby="publishedInfo">
            
                @error('happened_at')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">{{ trans('messages.fields.action') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($guildSieges as $guildSiege)
                    <tr>
                        <th scope="row">
                            {{ $guildSiege->id }}
                        </th>
                        <td>
                            {{ format_date($guildSiege->happened_at, true) }}
                        </td>
                        <td>
                            <a class="mx-1" href="" role="button"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        {{ $guildSieges->links() }}
    </div>
</div>
@endsection