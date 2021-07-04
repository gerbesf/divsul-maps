<div >


    <div wire:loading>
        <img src="{{ asset('loading.gif') }}">
    </div>
    <div wire:loading.remove>
    <div id="details-profile" class="pt-4">
        @if($profile)

            <div class="text-white" style="min-height:100vh">
                <div class="p-3">
                    <h1 class="text-3xl">{{ $profile['nickname'] }}</h1>
                    {{--   <pre>{{ print_r($profile) }}</pre>--}}
                    <button class="btn btn-sm btn-primary float-right" type="button" wire:click="backt">Back</button>
                </div>
                <div style="clear:both"></div>
                <div class="grid md:grid-cols-2">
                    <div>

                        @if($find_hash)
                            <h4 class="p-3">Search by Hash</h4>
                            <div class="bg-white p-2 text-gray-900" style="overflow-y: scroll; max-height: 80vh">
                                @foreach($find_hash as $hash=>$blockList)
                                    <table class="w-full" style="font-size: 12px">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Nick</th>
                                            <th>IP</th>
                                            <th>Tags</th>
                                        </tr>
                                        </thead>
                                        @foreach($blockList as $line)
                                            <tr>
                                                <td>{{ explode(' ',$line['data'])[0] }}</td>
                                                <td style="white-space: nowrap">{{ $line['nick'] }}</td>
                                                <td style="font-size: 8px">{{ $line['ip'] }}</td>
                                                <td style="font-size: 10px; text-transform: lowercase">
                                                    {{ implode(', ',$line['tags']) }}
                                                    @if($line['banned']) BANNED! @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endforeach
                            </div>
                        @endif

                    </div>
                    <div>
                        @if($find_ip)
                            <h4 class="p-3">Search by IP</h4>
                            <div class="bg-white p-2 text-gray-900" style="overflow-y: scroll; max-height: 80vh">
                                @foreach($find_ip as $hash=>$blockList)
                                    <table class="w-full" style="font-size: 12px">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Nick</th>
                                            <th>IP</th>
                                            <th>Tags</th>
                                        </tr>
                                        </thead>
                                        @foreach($blockList as $line)
                                            <tr>
                                                <td>{{ explode(' ',$line['data'])[0] }}</td>
                                                <td style="white-space: nowrap">{{ $line['nick'] }}</td>
                                                <td style="font-size: 8px">{{ $line['ip'] }}</td>
                                                <td style="font-size: 10px; text-transform: lowercase">
                                                    {{ implode(', ',$line['tags']) }}
                                                    @if($line['banned']) BANNED! @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endforeach
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        @endif
    </div>

    </div>

    @if(!$profile)



    <div class="border rounded p-4 bg-white" wire:poll.2750ms>

        <div class="float-right text-gray-400 pb-3">
            {{ now()->format('d/m/Y H:i:s') }}
        </div>

        <div class="float-left" >
            <label class="text-gray-400 text-sm">
                <input type="checkbox" wire:model="groupTeams" value="1"> Distinct Teams
            </label>
        </div>



        <div class="uppercase text-gray-400 text-center border-b">New Players / Out of Database</div>
        <div class="text-center pb-3">
            @foreach($offline as $itemOff)
                <div class="text-gray-600  m-1 px-2 rounded  inline-block">
                    <small>{{ $itemOff['nick'] }}</small>
                </div>
            @endforeach
        </div>
        <div style="font-size: 12px">

        @if($groupTeams==true)

            <div class="grid md:grid-cols-2 gap-3">

                <div>
                    <h4 class="bg-gray-100 p-3 font-bold text-2xl text-primary">Team 1</h4>
                    <div class="md:border md:p-3">
                        <div class="">
                            <table class="w-full text-left">
                                <thead class="font-bold border-b ">
                                <tr>
                                    <td class="text-center">Clan</td>
                                    <td>Nick</td>
                                    <td class="text-center">S</td>
                                    <td class="text-center">P</td>
                                    <td class="text-center">Nick</td>
                                    <td class="text-center">IP</td>

                                </tr>
                                </thead>
                                @foreach($results as $id=>$obj)
                                    @if($obj['team']==1)
                                        @include('livewire.players-online-line')
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div style="border-left: 1px solid #ededed">
                    <h4 class="bg-gray-100 p-3 font-bold text-2xl text-primary">Team 2</h4>
                    <div class="md:border md:p-3">

                        <div class="">
                            <table class="w-full">
                                <thead class="font-bold border-b ">
                                <tr>
                                    <td class="text-center ">Clan</td>
                                    <td>Nick</td>
                                    <td class="text-center">S</td>
                                    <td class="text-center">P</td>
                                    <td class="text-center">Nick</td>
                                    <td class="text-center">IP</td>
                                </tr>
                                </thead>
                                @foreach($results as $id=>$obj)
                                    @if($obj['team']==2)
                                        @include('livewire.players-online-line')
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            {{--
                        <pre class="text-white">{{ print_r(@$results) }}</pre>--}}
        @else

            <div class="">
                <table class="w-full">
                    <thead class="font-bold border-b ">
                    <tr>
                        <td class="text-center">Clan</td>
                        <td>Nick</td>
                        <td class="text-center">S</td>
                        <td class="text-center">P</td>
                        <td class="text-center">Nick</td>
                        <td class="text-center">IP</td>
                    </tr>
                    </thead>
                    @foreach($results as $id=>$obj)
                        @include('livewire.players-online-line')
                    @endforeach
                </table>
            </div>
            {{--<pre class="text-white">{{ print_r(@$results) }}</pre>
--}}


        @endif
        </div>
    </div>

    @endif



</div>
