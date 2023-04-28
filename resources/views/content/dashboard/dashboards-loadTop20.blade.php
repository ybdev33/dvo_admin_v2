    <table class="table table-condensed table-sm <?php echo ( $top20 ) ? "table-hover" : "" ?>">
        <thead>
            <tr>
                <th width="40"></th>
                <th width="120" class="text-center">Count</th>
                <th class="text-center">Comb</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @if( $top20 )
            @foreach($top20 as $i => $top)
            <tr>
                <td width="40" class="text-center">#{{$i+1}}</td>
                <td width="120" class="text-center">{{$top->betCount}}</td>
                <td class="text-center">{{$top->winCombination}}</td>
                <td class="text-end">{{$top->amount}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td width="40">&nbsp;</td>
                <td colspan="3" class="text-center" style="padding-top: 100px;">No data available.</td>
            </tr>
            @endif
        </tbody>
    </table>