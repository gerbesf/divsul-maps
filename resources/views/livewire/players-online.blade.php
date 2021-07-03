<div >

    <div class="grid grid-cols-2">
    {{--    <div>
            --}}{{--
                        <select wire:model="selectedClan" class="input input-bordered text-white block mt-1 w-full">
                            <option value="0">All Clans</option>
                            @foreach($clans as $clan)
                                <option value="{{ $clan }}">{{ $clan }}</option>
                            @endforeach
                        </select>--}}{{--
        </div>--}}
        <div>

            <div class="p-4">

                <label class="text-white">
                    <input type="checkbox" wire:model="groupTeams" value="1"> Distinct Teams
                </label>
            </div>

        </div>
        {{--<div>

            <div class="p-4">

                <label class="text-white">
                    <input type="checkbox" wire:model="highOnly" value="1"> Alert Only
                </label>
            </div>

        </div>--}}
    </div>


    <div class="border rounded p-4 bg-white" wire:poll>

        {{--        <div class="text-center text-gray-400 pb-3">
                    {{ now()->format('d/m/Y H:i:s') }}
                </div>--}}

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

</div>
