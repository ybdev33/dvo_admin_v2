    <style>
        @page {
            margin: 20px;
            size: A4;
        }

        div.report {
            font-family: "Public Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            text-align: center;
            background-color: #fff;
            margin: 0;
            padding: 0 20px;
        }

        table {
            width: 50%;
            padding: 0;
            font-size: 11px;
        }

        table.table-area {
            border: 2px solid #000;
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

        table tr td.amount {
            border-bottom: 2px solid #000;
        }

        table tr td.amount {
            border-bottom: 2px solid #000;
        }

        table tr td.amount span {
            text-align: left;
        }

        /* .table-wrapper {
            background-color: #ddd;
        } */
        .table-column {
            column-gap: 5rem;
            columns: auto 4;
            column-count: 4;
            display: block;
            orphans: 3;
            width: auto;
        }
        .table-column.min4 {
            height: 24cm;
            column-fill: auto;
        }
        @media only screen and (max-width: 650px) {
            #report-pdf {
                overflow-x: auto;
            }

            #report-pdf table {
                width: 145%;
            }
        }
    </style>

    <div id="report-print" class="report">
        <h4>{{config('variables.templateName')}} - TALLY SHEET</h4>
        <?php
        $datefrom = date_create(\Request::get('datefrom'));
        $dateto = date_create(\Request::get('dateto'));
        ?>
        <h5><?php echo $options['json']['drawcategory'] ?> <?php echo date_format($datefrom, "m/d/Y"); ?> - <?php echo date_format($dateto, "m/d/Y"); ?> <?php echo date("h:i A"); ?></h5>
        <br />
        <?php
        $total = 0;
        // echo "<pre>";
        // print_r($datas);
        // echo "</pre>";
        // die();
        ?>
        <div class="table-wrapper">
            <table width="100%" style="vertical-align: top;" class="table-column">
                @foreach($datas as $d => $data)
                <?php
                $total += $data->amount;
                ?>
                <tr>
                    <td>{{$data->winCombination}}</td>
                    <td class="amount">
                        <span>:</span>
                    </td>
                    <td class="amount" style="width: 120px">
                        <span>{{$data->amount}}</span>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <table width="100%" cellspacing="0" style="width: 100%;">
            <tr>
                <td style="display: inline-block; position: relative; width: 100%; padding-top: 10px; font-size: 16px; font-weight:bold;">
                    <u>Total -- <?php echo $total ?></u>
                </td>
            </tr>
        </table>
    </div>