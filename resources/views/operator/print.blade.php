<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $weighing->ticket_number }} - Print Slip</title>
    <style>
        body {
            background: #fff;
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #000;
        }

        .a4-page {
            width: 190mm; /* Sized for print margins */
            margin: 5mm auto;
            box-sizing: border-box;
            padding: 10mm;
        }

        .text-center {
            text-align: center;
        }

        .header-title {
            font-size: 26px;
            font-weight: bold;
            color: #900;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header-subtitle {
            font-size: 13px;
            margin: 2px 0;
            font-style: italic;
        }

        .slip-title {
            font-size: 18px;
            font-weight: bold;
            color: #00007c;
            border-bottom: 2px solid #00007c;
            display: inline-block;
            padding-bottom: 3px;
            margin-top: 15px;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .meta-table, .weight-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .meta-table td {
            padding: 6px 8px;
            vertical-align: top;
            border: 1px solid #000;
        }

        .meta-table td.label {
            font-weight: bold;
            width: 18%;
        }

        .meta-table td.value {
            width: 32%;
        }

        .weight-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 8px;
        }

        .weight-table td {
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
        }

        .weight-table .highlight {
            font-size: 16px;
            font-weight: bold;
        }

        .signatures-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-line {
            width: 30%;
            border-top: 1px solid #000;
            text-align: center;
            padding-top: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .a4-page {
                width: 100%;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    
    <!-- Quick action bar (hidden during print) -->
    <div class="no-print" style="background: #f1f1f1; padding: 10px; text-align: center; border-bottom: 1px solid #ccc;">
        <button onclick="window.print();" style="padding: 8px 16px; font-weight: bold; background: #00007c; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Slip
        </button>
        <button onclick="window.close();" style="padding: 8px 16px; margin-left: 10px; background: #666; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Close Tab
        </button>
    </div>

    <div class="a4-page">
        <!-- Header -->
        <div class="text-center">
            <h1 class="header-title">{{ $company->company_name }}</h1>
            <p class="header-subtitle" style="font-size: 15px; font-style: normal; font-weight: bold;">{{ $company->company_address }}</p>
            <p class="header-subtitle">Phone: {{ $company->company_phone }}@if($company->company_email) | Email: {{ $company->company_email }}@endif</p>
            <div class="slip-title">WEIGHBRIDGE WEIGHT SLIP</div>
        </div>

        <!-- Meta Information Grid -->
        <table class="meta-table">
            <tr>
                <td class="label">Weight ID</td>
                <td class="value" style="font-weight: bold;">#{{ $weighing->ticket_number }}</td>
                <td class="label">Challan Ref</td>
                <td class="value">{{ $weighing->challan_reference ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Vehicle No</td>
                <td class="value" style="font-weight: bold; font-size: 15px;">{{ $weighing->vehicle->vehicle_number }}</td>
                <td class="label">Client Name</td>
                <td class="value" style="font-weight: bold;">{{ $weighing->party->name }}</td>
            </tr>
            <tr>
                <td class="label">Driver Name</td>
                <td class="value">{{ $weighing->driver_name ?? 'N/A' }}</td>
                <td class="label">Client Address</td>
                <td class="value">{{ $weighing->party->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Driver Contact</td>
                <td class="value">{{ $weighing->driver_phone ?? 'N/A' }}</td>
                <td class="label">Contact Person</td>
                <td class="value">{{ $weighing->party->contact_person ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Product Name</td>
                <td class="value" style="font-weight: bold;">{{ $weighing->product_name ?? 'N/A' }}</td>
                <td class="label">Contact Phone</td>
                <td class="value">{{ $weighing->party->contact_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Quantity</td>
                <td class="value">{{ $weighing->quantity ? number_format($weighing->quantity, 2) : 'N/A' }}</td>
                <td class="label">Transport Co.</td>
                <td class="value">{{ $weighing->transport_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">No. of Wheels</td>
                <td class="value">{{ $weighing->wheels_count ? $weighing->wheels_count . ' Wheels' : 'N/A' }}</td>
                <td class="label">Printed Date</td>
                <td class="value">{{ now()->format('d/m/Y h:i A') }}</td>
            </tr>
        </table>

        <!-- Weight Measurements -->
        <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; margin-top: 25px;">Weight Measurements</h3>
        <table class="weight-table">
            <thead>
                <tr>
                    <th width="33%">Measurement Type</th>
                    <th width="33%">Weight (KG)</th>
                    <th width="34%">Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">First Weight</td>
                    <td class="highlight" style="color: #900;">{{ number_format($weighing->first_weight, 2) }} kg</td>
                    <td>{{ $weighing->first_weight_datetime->format('d/m/Y h:i:s A') }}</td>
                </tr>
                @if ($weighing->second_weight)
                    <tr>
                        <td style="font-weight: bold;">Second Weight</td>
                        <td class="highlight" style="color: #090;">{{ number_format($weighing->second_weight, 2) }} kg</td>
                        <td>{{ $weighing->second_weight_datetime->format('d/m/Y h:i:s A') }}</td>
                    </tr>
                    <tr style="background-color: #f9f9f9; font-size: 16px;">
                        <td style="font-weight: bold; border-top: 2px double #000;">Net Payload Weight</td>
                        <td class="highlight" style="color: #00007c; border-top: 2px double #000; font-size: 18px;">
                            {{ number_format($weighing->net_weight, 2) }} kg
                        </td>
                        <td style="border-top: 2px double #000; font-style: italic; font-size: 12px;">
                            Calculated Payload
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="3" style="font-style: italic; color: #888; padding: 15px;">
                            Second weight pending...
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Footer terms / info -->
        @if($company->receipt_footer_text)
            <div style="text-align: center; margin-top: 30px; font-size: 12px; font-style: italic;">
                {{ $company->receipt_footer_text }}
            </div>
        @endif

        <!-- Signatures -->
        <div class="signatures-section">
            <div class="signature-line">Driver's Signature</div>
            <div class="signature-line">Operator: {{ $weighing->creator->name }}</div>
            <div class="signature-line">Authorized Signature</div>
        </div>
    </div>

    <script>
        // Auto trigger browser print dialog on load
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
