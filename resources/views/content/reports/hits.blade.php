<style type="text/css">
    @page {
        margin: 0px;
        size: A4;
    }

    div.report {
        font-family: "Public Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        text-align: center;
        background-color: #fff;
        margin: 0px;
        padding: 20px;
        height: 24cm;
    }

    div.report table {
        width: 100%;
        padding: 0;
        font-size: 11px;
        /* column-fill: auto;
        column-gap: 1rem;
        column-rule: 0px none transparent;
        columns: auto 2;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: block; */
    }

    div.report table td,
    div.report table th {
        border: 1px solid black;
        text-align: center;
    }

    div.report table tr,
    div.report table td {
        padding: 5px;
    }

    /* .table-column {
        column-fill: auto;
        column-gap: 1rem;
        column-rule: 0px none transparent;
        columns: auto 1;
        height: 24cm;
        overflow: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: table-cell;
        width: 50%;
        clear: both;
        page-break-after: always;
    } */
</style>

<div class="report">
    <h3>Hits Report</h3>
    <h4>Date <?php echo $options['date'] ?></h4>

    <table width="100%" cellspacing="0" class="table-column">

        <tr style="vertical-align: top;">
            <th width="10%">Hits</th>
            <th width="25%">Date</th>
            <th width="10%">Transcode</th>
            <th width="10%">Draw Category</th>
            <th width="10%">Win Combination</th>
            <th width="10%">Amount</th>
            <th width="10%">Win Amount</th>
        </tr>

        @foreach($datas as $k => $data)
        <tr style="vertical-align: top;">
            <td>{{$data->hitsId}}</td>
            <td>{{$data->date ? \Carbon\Carbon::parse($data->date)->format('d/m/Y') : ''}}</td>
            <td>{{$data->generatedId}}</td>
            <td>{{$data->drawCategory}}</td>
            <td>{{$data->winCombination}}</td>
            <td>{{$data->amount}}</td>
            <td>{{$data->winAmount}}</td>
        </tr>
        @endforeach
    </table>
</div>