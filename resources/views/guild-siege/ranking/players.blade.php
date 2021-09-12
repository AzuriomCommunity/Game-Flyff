<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">{{ trans('messages.fields.name') }}</th>
            <th scope="col">{{trans('flyff::messages.kills')}}</th>
            <th scope="col">Score</th>
            <th scope="col">{{trans('flyff::messages.guild')}}</th>
            <th scope="col">{{ trans('messages.fields.action') }}</th>
        </tr>
        </thead>
        <tbody>

            @foreach($player_ranking as $player_name => $player_rank)
                <tr>
                    <th scope="row">{{$player_name}}</th>
                    <td>{{count($player_rank['kills'])}}</td>
                    <td>{{$player_rank['score']}}</td>
                    <td>{{$player_rank['guild']}}</td>
                    <td>
                        <a class="mx-1" data-toggle="collapse" href="#collapse-player-{{$loop->index}}" role="button" aria-expanded="false" aria-controls="collapse-player-{{$loop->index}}"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr class="collapse" id="collapse-player-{{$loop->index}}">
                    <td colspan="5">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">{{trans('flyff::messages.kills')}}</h5>
                                <ul class="list-unstyled">
                                    @foreach ($player_rank['kills'] as $life_number => $kills)
                                        <h6>{{trans('flyff::messages.life')}} {{$life_number}}:</h6>
                                            
                                        @foreach ($kills as $player_name => $times)
                                            <li>
                                                {{ $player_name.' x'.$times}}
                                            </li>
                                        @endforeach
                                        
                                    @endforeach
                                    
                                </ul>
                            </div>
                            <div class="col">
                                <h5 class="text-center">{{trans('flyff::messages.deaths')}}</h5>
                                <ul class="list-unstyled">
                                    @foreach ($player_rank['deaths'] as $life_number => $killedBy)
                                        <li>
                                            {{ $life_number.'. '.$killedBy}}
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
