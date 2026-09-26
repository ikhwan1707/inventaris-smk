<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $judul ?? 'Laporan' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header h3 {
            margin: 2px 0 0;
            font-size: 14px;
        }

        .header p {
            margin: 2px 0 0;
            font-size: 11px;
        }

        .info {
            margin-bottom: 10px;
            font-size: 11px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 1px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #333;
            padding: 4px 5px;
            vertical-align: top;
        }

        table.data th {
            background-color: #e9ecef;
            text-align: center;
        }

        table.data td.text-right {
            text-align: right;
        }

        table.data tfoot th {
            background-color: #f1f1f1;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>SMK INFORMATIKA UTAMA DEPOK</h2>
        <h3>PROGRAM KEAHLIAN REKAYASA PERANGKAT LUNAK</h3>
        <p>Sistem Informasi Inventaris Barang</p>
    </div>

    <h3 style="text-align:center; margin-bottom:15px;">{{ $judul ?? 'Laporan' }}</h3>

    @if(!empty($periode))
    <div class="info">
        <table>
            <tr>
                <td width="100"><strong>Periode</strong></td>
                <td width="10">:</td>
                <td>{{ $periode }}</td>
            </tr>
            <tr>
                <td><strong>Dicetak</strong></td>
                <td>:</td>
                <td>{{ $tanggal ?? \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
    </div>
    @endif

    @yield('content')

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB
    </div>

</body>

</html>