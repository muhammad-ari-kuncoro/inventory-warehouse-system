<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $deliveryOrder->do_no }}</title>
    <style>
        * {
            margin-top: 8px;
            box-sizing: border-box;
            /* Pastikan padding dan border tidak memengaruhi ukuran elemen */
        }

        table {
            border-collapse: collapse;
            /* Menggabungkan border */
            border-spacing: 0;
            /* Menghilangkan jarak antar sel */
        }

        .border-full {
            border: 1px solid black;
        }

        .border-bottom {
            border-bottom: 1px solid black;
        }

        .border-top {
            border-top: 1px solid black;
        }

        .border-right {
            border-right: 1px solid black;
        }

        .border-left {
            border-left: 1px solid black;
        }

        .w-full {
            width: 100%;
        }

        .w-auto {
            width: auto;
        }

        .text-header-sm {
            font-size: 12px;
            font-weight: 500;
        }

        .text-header-md {
            font-size: 14px;
            font-weight: 500;
        }

        .text-header-xl {
            font-size: 18px;
            font-weight: 500;
        }

        .text-sm {
            font-size: 12px;
        }

        .text-xl {
            font-size: 18px;
        }

        .text-center {
            text-align: center;
        }

        .bg-gray {
            background-color: #808080;
        }

        .bg-sky {
            background-color: #95B3D7;
        }
    </style>
</head>

<body>
    <table class="w-full">
        <tbody>
            <tr>
                <td rowspan="4" class="border-full" style="width: 150px;"><img
                        src="{{ public_path('asset/img/img-import/thumb_armindo_jaya_mandiri-removebg-preview.png') }}"
                        alt="" width="150px" height="75px"></td>
                <td class="border-full text-header-sm text-center">FORM</td>
                <td class="border-full text-header-sm text-center">No. Dok</td>
                <td class="border-full text-header-sm">AJM/MTK/F/01/05</td>
            </tr>
            <tr>
                <td rowspan="3" class="border-full text-header-xl text-center" style="width: 320px">DELIVERY ORDER
                </td>
                <td class="border-right text-header-sm">Rev.</td>
                <td class="border-right border-bottom text-header-sm">0</td>
            </tr>
            <tr>
                <td class="border-right text-header-sm" style="width: 100px">Tanggal</td>
                <td class="border-right border-bottom text-header-sm">{{ $deliveryOrder->do_date }}</td>
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
                   {{ $deliveryOrder->project->nama_project }}
                    <br>
                    {{ $deliveryOrder->shipment_address }} <br>
                    <br>
                    <br>
                    Phone : <br>
                    Fax :
                </p>
            </td>
            <td class="text-sm text-center border-full">
                {{ $deliveryOrder->created_at->format('d F Y') }}
            </td>
        </tr>
        <tr>
            <td class="text-header-sm bg-gray text-center border-full">Delivery No.</td>
        </tr>
        <tr>
            <td class="text-sm text-center border-full">{{ $deliveryOrder->do_no }}</td>
        </tr>
        <tr>
            <td class="text-header-sm bg-gray text-center border-full">PN No</td>
        </tr>
        <tr>
            <td class="text-sm text-center border-full">{{ $deliveryOrder->project->kode_project }}</td>
        </tr>
    </table>

    <table class="w-full">
        <tr class="bg-sky">
            <td class="text-header-md text-center">No</td>
            <td class="text-header-md text-center">Item Description</td>
            <td class="text-header-md text-center">Item Size</td>
            <td class="text-header-md text-center">Weight Items</td>
            <td class="text-header-md text-center">Qty</td>
            <td class="text-header-md text-center">Satuan</td>
        </tr>
        @if ($deliveryOrder)
            @foreach ($deliveryOrder->details as $detail)
                <tr>

                <td class="border-full text-sm text-center">{{ $loop->iteration }}</td>
                <td class="border-full text-sm">{{ $detail->item_description }}</td>
                <td class="border-full text-sm text-center">{{ $detail->item_size }}</td>
                <td class="border-full text-sm text-center">± {{ $detail->item_weight }} Kg</td>
                <td class="border-full text-sm text-center">{{ $detail->item_qty }}</td>
                <td class="border-full text-sm text-center">{{ $detail->item_measurement }}</td>
                </tr>
                <tr>

                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">No Item Found</td>
                    </tr>
                @endif
        </tr>

        <tr>
            <td colspan="2" class="text-center text-sm border-full">Total</td>
            <td class="text-center text-sm border-full"></td>
            <td class="text-center text-sm border-full">± {{$totalWeight}} (Kgs)</td>
            <td class="text-center text-sm border-full">{{ $totalQty }}</td>
            <td class="text-center text-sm border-full">Unit</td>
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
               Date:  {{ $deliveryOrder->created_at->format('d F Y') }}
            </td>
            <td class="text-sm">
                Date: {{ $deliveryOrder->created_at->format('d F Y') }}
            </td>
            <td class="text-sm">
                Date: {{ $deliveryOrder->created_at->format('d F Y') }}
            </td>
            <td class="">
            </td>
            <td class="text-sm">
                Date" {{ $deliveryOrder->created_at->format('d F Y') }}
            </td>
        </tr>
    </table>
</body>

</html>
