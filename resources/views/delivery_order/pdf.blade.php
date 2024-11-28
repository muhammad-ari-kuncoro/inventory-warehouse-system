<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $deliveryOrder->do_no }}</title>
    <style>
        * {
            margin-top: 8px;
            box-sizing: border-box; /* Pastikan padding dan border tidak memengaruhi ukuran elemen */
        }

        table {
            border-collapse: collapse; /* Menggabungkan border */
            border-spacing: 0;         /* Menghilangkan jarak antar sel */
        }
        .border-full{
            border: 1px solid black;
        }

        .border-bottom{
            border-bottom: 1px solid black;
        }

        .border-top{
            border-top: 1px solid black;
        }
        
        .border-right{
            border-right: 1px solid black;
        }
        
        .border-left{
            border-left: 1px solid black;
        }

        .w-full {
            width: 100%;
        }

        .w-auto{
            width: auto;
        }

        .text-header-sm{
            font-size: 10px;
            font-weight: 500;
        }
        
        .text-header-md{
            font-size: 13px;
            font-weight: 500;
        }

        .text-header-xl{
            font-size: 18px;
            font-weight: 500;
        }
        
        .text-sm{
            font-size: 10px;
        }
        
        .text-xl{
            font-size: 18px;
        }

        .text-center{
            text-align: center;
        }

        .bg-gray{
            background-color: #808080;
        }

        .bg-sky{
            background-color: #95B3D7;
        }
    </style>
</head>
<body>
    <table class="w-full">
        <tbody>
            <tr>
                <td rowspan="4" class="border-full" style="width: 150px;"><img src="{{ public_path('asset/img/img-import/thumb_armindo_jaya_mandiri-removebg-preview.png') }}" alt="" width="150px" height="75px"></td>
                <td class="border-full text-header-sm text-center">FORM</td>
                <td class="border-full text-header-sm text-center">No. Dok</td>
                <td class="border-full text-header-sm">AJM/MTK/F/01/05</td>
            </tr>
            <tr>
                <td rowspan="3" class="border-full text-header-xl text-center" style="width: 320px">DELIVERY ORDER</td>
                <td class="border-right text-header-sm">Rev.</td>
                <td class="border-right border-bottom text-header-sm">0</td>
            </tr>
            <tr>
                <td class="border-right text-header-sm" style="width: 100px">Tanggal</td>
                <td class="border-right border-bottom text-header-sm">04/02/2022</td>
            </tr>
            <tr>
                <td class="border-bottom border-right text-header-sm">Halaman</td>
                <td class="border-bottom border-right text-header-sm">1 dari 1</td>
            </tr>
        </tbody>
    </table>

    <table class="w-full">
        <tr>
            <td class="border-full text-header-sm text-center bg-gray">Shipper</td>
            <td class="border-full text-header-sm text-center bg-gray">Ship To</td>
            <td class="border-full text-header-sm text-center bg-gray">Delivery Date</td>
        </tr>
        <tr>
            <td rowspan="5" class="border-full" style="width: 220px;">
                <p class="text-sm">
                    PT. ARMINDO JAYA MANDIRI <br>
                    Kawasan Industri Jababeka II, <br>
                    Jl. Industri Selatan 7 Blok FF 1F Cikarang <br>
                    Bekasi 17550 <br>
                    <br>
                    Phone : +6221 8984 2752 <br>
                    Fax : +6221 8984 2751
                </p>
            </td>
            <td rowspan="5" class="border-full" style="width: 350px;">
                <p class="text-sm">
                    PT.GT LADANG <br>
                    ALAMANDA TOWER,JL.TB SIMATUPANG NO.1 1/RT.1/RW.1 12430 <br>
                    DAERAH KHUSUS IBUKOTA JAKARTA JAWA 40 KM <br>
                    <br>
                    Phone : <br>
                    Fax :
                </p>
            </td>
            <td class="text-sm text-center border-full">
                17 Oktober 2024
            </td>
        </tr>
        <tr>
            <td class="text-header-sm bg-gray text-center border-full">Delivery No.</td>
        </tr>
        <tr>
            <td class="text-sm text-center border-full">DO/AJM/0/VII/24/81</td>
        </tr>
        <tr>
            <td class="text-header-sm bg-gray text-center border-full">PO No</td>
        </tr>
        <tr>
            <td class="text-sm text-center border-full">POC254-A240004-BO002</td>
        </tr>
    </table>

    <table class="w-full">
        <tr class="bg-sky">
            <td class="text-header-md text-center">No</td>
            <td class="text-header-md text-center">Item Description</td>
            <td class="text-header-md text-center">Item Size</td>
            <td class="text-header-md text-center">Qty</td>
            <td class="text-header-md text-center">Satuan</td>
        </tr>
        @for($i = 1; $i <= 40; $i++)
            <tr>
                <td class="border-full text-sm"></td>
                <td class="border-full text-sm">HPA - 02 - 10" B19 - V - SHT 5 OF 5 - J.72</td>
                <td class="border-full text-sm"></td>
                <td class="border-full text-sm"></td>
                <td class="border-full text-sm"></td>
            </tr>
        @endfor
        <tr>
            <td colspan="2" class="text-center text-sm border-full">Total</td>
            <td class="text-center text-sm border-full">11,60 M2</td>
            <td class="text-center text-sm border-full">7</td>
            <td class="text-center text-sm border-full">UNIT SPOOL</td>
        </tr>
    </table>

    <table class="w-full" style="margin-top: -30px;">
        <tr>
            <td class="text-sm" style="height: 150px;">
                Disiapkan Oleh, 
            </td>
            <td class="text-sm" style="height: 150px;">
                Disetujui Oleh, 
            </td>
            <td class="text-sm" style="height: 150px;">
                Dikirim Oleh, 
            </td>
            <td style="width: 100px;">
            </td>
            <td class="text-sm" style="height: 150px;">
                Diterima Oleh, 
            </td>
        </tr>
        <tr>
            <td class="text-sm">
                Date: 17 Oktober 2024
            </td>
            <td class="text-sm">
                Date: 17 Oktober 2024
            </td>
            <td class="text-sm">
                Date: 17 Oktober 2024
            </td>
            <td class="">
            </td>
            <td class="text-sm">
                Date: 17 Oktober 2024
            </td>
        </tr>
    </table>
</body>
</html>