<style>
    .table-area .table-sm th {
        font-size: 12px;
        background-color: #d7f5fc !important;
    }
</style>

<div class="table-area text-nowrap mt-3 pt-0 p-3">
    <table id="users" class="table table-condensed table-sm table-hover table-responsive" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th width="50%">Area</th>
                <th width="25%">Bet</th>
                <th width="25%">Hits</th>
                <th width="25%">Net</th>
            </tr>
        </thead>
        <tbody>
            @if($datas->dashUser)
            @foreach($datas->dashUser as $d => $data)
            <tr data-bs-toggle="collapse" data-bs-target="#area<?php echo $options['json']['drawcategory'] . '-' . $d ?>" aria-expanded="false" aria-controls="#area<?php echo $d ?>" style="<?php echo !empty($data->dashDetail) ? 'cursor: pointer' : '' ?>">
                <td width="50%" class="<?php echo !empty($data->dashDetail) ? 'text-info' : '' ?> area-name" title="<?php echo $data->areaName ?>"><span>{{$data->areaName}}</span></td>
                <td width="25%">{{$data->bet}}</td>
                <td width="25%">{{$data->hits}}</td>
                <td width="12.5%"><span class="<?php echo str_contains($data->net, '-') ? 'text-danger' : '' ?>">{{$data->net}}</span></td>
            </tr>
            <?php if (!empty($data->dashDetail)) : ?>
                <tr class="collapse" id="area<?php echo $options['json']['drawcategory'] . '-' . $d ?>">
                    <td colspan="4" style="padding: 0; background-color: #f5fcfe;">
                        <div class="text-nowrap">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width="25%">Win Com</th>
                                        <th colspan="2" width="25%">genId</th>
                                        <th width="25%">Amt</th>
                                        <th width="25%">Win Amt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->dashDetail as $l => $loc)
                                    <tr>
                                        <td>{{$loc->winCombination}}</td>
                                        <td colspan="2">{{$loc->generatedId}}</td>
                                        <td>{{$loc->amount}}</td>
                                        <td>{{$loc->winAmount}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            @endforeach
            @else
            <tr>
                <td colspan="4" align="center">
                    No data available
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>