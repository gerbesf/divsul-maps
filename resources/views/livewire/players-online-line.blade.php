@if(in_array('high_risk',$obj['tags']) && $highOnly==true or $highOnly==false)

    <tr class="
    border-b hover:bg-gray-50

    @if(in_array('high_risk',$obj['tags']))
        @if(count($obj['nicks'])==0 && count($obj['ips'])==0)
            text-warning -600
        @else
            text-red-600
        @endif
    @endif ">

        <td class="text-center">
            {{ $obj['tag'] }}
        </td>
        <td>
            <span class="font-bold">{{ $obj['nick'] }}</span>
                @if(in_array('legacy',$obj['tags']))
                    <span class="p-1 rounded border-0 text-primary bg-gray-100">L</span>
                @endif
            @if($obj['banned'])
                <span class="text-danger"> <small>! Banned !</small> </span>
            @endif
        </td>
        <td class="text-center">
            {{ $obj['score'] }}
        </td>
        <td class="text-center">
            <b>{{$obj['kills']}}</b><small class="text-gray-400">/</small>{{$obj['deaths']}}
        </td>
        <td class="text-center">
            {{ count($obj['nicks']) }}
        </td>
        <td class="text-center">
            {{ count($obj['ips']) }}
        </td>
        {{--td>
            @if($obj['banned'])
                <span class="text-danger"> <small>Banned</small> </span>
            @endif
        </td>--}}
    </tr>

    {{-- <div class="pl-3">
         <small class="text-gray-400">{{ implode(' -- ',$obj['nicks']) }}</small>
     </div>--}}
@endif
