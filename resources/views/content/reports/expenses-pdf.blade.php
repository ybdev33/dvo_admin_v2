<style>
    @page {
        margin: 0;
        padding: 0;
        size: A4;
    }

    div.report {
        font-family: "Public Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        text-align: center;
        background-color: #fff;
        margin: 0px;
        padding: 5px;
    }

    table {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        padding: 0;
        font-size: 11px;
    }

    table.table-area {
        border: 1px solid #000;
        margin-bottom: 15px
    }

    table tr th {
        padding: 0;
        font-weight: 500;
    }

    table tr td {
        padding: 0;
        text-align: center;
    }

    table tr.border-top td {
        border-top: 1px solid #000;
    }

    table tr.border-bottom th {
        border-bottom: 1px solid #000;
    }

    table .border-left {
        border-left: 1px solid #000;
    }

    table .border-right {
        border-right: 1px solid #000;
    }

    table tr.border-none td {
        border: none;
    }

    table .text-left {
        text-align: left;
        padding-left: 10px;
    }

    table .text-right {
        text-align: right;
        padding-right: 10px;
    }

    table .total-area {
        font-weight: 500;
    }

    table tr.total-area th {
        vertical-align: bottom;
    }

    .table-column {
        column-fill: auto;
        column-gap: 1rem;
        column-rule: 0px none transparent;
        columns: auto 2;
        height: 24cm;
        overflow: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    @media only screen and (max-width: 650px) {
        #report-pdf {
            overflow-x: auto;
        }

        #report-pdf table {
            width: 145%;
        }

        #wrapper-pdf {
            padding: 5px !important;
        }

        .ui-bg-overlay-container.p-4 {
            padding: 1rem !important;
        }
        table .text-left {
            width: 40px;
        }
        table .text-right {
            display: inherit;
        }
    }
</style>

<div class="report">
    <h3>Stall Summary</h3>
    <?php
    $grossGrand = $expAmtGrand = $winAmtGrand = $netGrand = 0;
    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    // die();

    $datefrom = date_create(\Request::get('datefrom'));
    $dateto = date_create(\Request::get('dateto'));
    ?>
    <h4><?php echo date_format($datefrom, "m/d/Y"); ?> - <?php echo date_format($dateto, "m/d/Y"); ?> <?php echo date("h:i A"); ?></h4>

    <table width="100%">
        <tr>
            <td style="vertical-align: top;" class="table-column">
                @foreach($grouped as $user => $data)
                <table width="100%" cellspacing="0" class="table-area">
                    <thead>
                        <tr class="border-bottom">
                            <th rowspan="2" width="20%" class="border-right">
                                {{$user}}
                            </th>
                            @foreach($data as $d => $draw)
                            <th colspan="4">DRAW {{$d}}</th>
                            @endforeach
                        </tr>
                        <tr class="border-bottom">
                            @foreach($data as $d => $draw)
                            <th width="20%">Gross</th>
                            <th width="20%">Hits</th>
                            <th width="20%">Expenses</th>
                            <th width="20%">Net</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grossTotal = $expAmtTotal = $winAmtTotal = $netTotal = $areaTotal = 0;
                        ?>
                        @foreach($draw as $area => $val)
                        <tr class="border-bottom">
                            <td class="text-left border-right">{{$area}}</td>
                            @foreach($val as $k => $v)
                            <?php
                            $v = (object) $v;
                            $grossTotal += $v->gross;
                            $winAmtTotal += $v->winAmt;
                            $expAmtTotal += $v->expense;
                            $netTotal += $v->net;
                            ?>
                            <td>{{$v->gross}}</td>
                            <td>{{$v->winAmt}}</td>
                            <td>{{$v->expense}}</td>
                            <td>{{$v->net}}</td>
                            @endforeach
                        </tr>
                        <?php $areaTotal++; ?>
                        @endforeach
                        <?php
                        $grossGrand += $grossTotal;
                        $winAmtGrand += $winAmtTotal;
                        $expAmtGrand += $expAmtTotal;
                        $netGrand += $netTotal;
                        ?>
                        <tr class="border-top total-area">
                            <td class="border-right">
                                <table width="100%">
                                    <tr class="border-none total-area">
                                        <td class="text-left">
                                            Total
                                        </td>
                                        <td class="text-right">
                                            {{$areaTotal}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>{{$grossTotal}}</td>
                            <td>{{$winAmtTotal}}</td>
                            <td>{{$expAmtTotal}}</td>
                            <td>{{$netTotal}}</td>
                        </tr>
                    </tbody>
                </table>
                @endforeach

            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellspacing="0">
                    <td style="display: inline-block; position: relative; width: 50%; padding-top: 15px;">
                        <table width="50%">
                            <thead>
                                <tr class="total-area">
                                    <th width="20%">&nbsp;</th>
                                    @foreach($data as $d => $draw)
                                    <th width="20%">Gross</th>
                                    <th width="20%">Hits</th>
                                    <th width="20%">Expenses</th>
                                    <th width="20%">Net</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="total-area">
                                    <td width="20%" style="border-bottom: 3px double #000;">Overall Total:</td>
                                    <td width="20%">{{$grossGrand}}</td>
                                    <td width="20%">{{$winAmtGrand}}</td>
                                    <td width="20%">{{$expAmtGrand}}</td>
                                    <td width="20%">{{$netGrand}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="display: inline-block; position: relative; width: 50%; vertical-align: bottom; padding-top: 15px;">
                        <table width="50%">
                            <tr>
                                <td style="text-align: right; ">
                                    <u><?php echo $datas_count ?> -- ACTIVE GADGETS</u>
                                </td>
                            </tr>
                        </table>
                    </td>
                </table>

            </td>
        </tr>
    </table>
</div>