<!DOCTYPE html>
<html>

<head>
    <title>2M-STALL-SUMMARY</title>
    <style>
        body.report {
            font-family: "Public Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            text-align: center;
        }

        table {
            margin-left: auto;
            margin-right: auto;
            padding: 0;
        }

        table tr th {
            border: 1px solid #000;
            padding: 0;
            font-weight: 500;
        }

        table tr td {
            border: 1px solid #000;
            padding: 0;
            text-align: center;
        }

        table tr td.left {
            text-align: left;
            padding-left: 10px;
        }

        table.no_border tr td {
            border: none;

        }
        table.bottom_border tr td {
            border: none;
            border-bottom: 3px double #000;
        }

        table tr td.f500 {
            font-weight: 500;
        }
    </style>
</head>

<body class="report">
    <h4>Hits Report</h4>

    <table width="80%" cellspacing="0">
        @foreach($datas as $k => $data)
        <tr>
            <td class="left">{{$data}}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>