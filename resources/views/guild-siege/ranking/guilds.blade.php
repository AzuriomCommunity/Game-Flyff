<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">{{trans('flyff::messages.rank')}}</th>
            <th scope="col">{{trans('flyff::messages.guild')}}</th>
            <th scope="col">Points</th>
            <th scope="col">{{trans('flyff::messages.player-number')}}</th>
            <th scope="col">{{ trans('messages.fields.action') }}</th>
        </tr>
        </thead>
        <tbody>

            @foreach($guild_ranking as $guild_name => $guild_rank)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$guild_name}}</td>
                    <td>{{$guild_rank['totalScore']}}</td>
                    <td>{{count($guild_rank['members'])}}</td>
                    <td>
                        <a class="mx-1" data-bs-toggle="collapse" href="#collapse-guild-{{$loop->index}}" role="button" aria-expanded="false" aria-controls="collapse-guild-{{$loop->index}}"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
                <tr class="collapse" id="collapse-guild-{{$loop->index}}">
                    <td colspan="5">
                        <table class="table table-condensed">
                            <tbody>
                                <tr>
                                    <td>{{trans('flyff::messages.members')}}</td>
                                    <td>Score</td>
                                </tr>
                                @foreach ($guild_rank['members'] as $member_name => $score)
                                    <tr>
                                        <td>{{ ($loop->index+1).'. '.$member_name}}</td>
                                        <td>{{$score}}</td>
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
