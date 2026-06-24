<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Vessel: {{ $vessel->name }}</title>
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
            width: 190mm;
            margin: 5mm auto;
            box-sizing: border-box;
            padding: 10mm;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
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
        }

        .slip-title {
            font-size: 18px;
            font-weight: bold;
            color: #00007c;
            border-bottom: 2px solid #00007c;
            display: inline-block;
            padding-bottom: 3px;
            margin-top: 15px;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .invoice-meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .invoice-meta-table td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .invoice-meta-table td.label {
            font-weight: bold;
            width: 20%;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .invoice-meta-table td.value {
            width: 30%;
            border: 1px solid #ddd;
        }

        .bill-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .bill-summary-table th {
            background-color: #00007c;
            color: white;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 8px;
            text-transform: uppercase;
        }

        .bill-summary-table td {
            padding: 10px;
            border: 1px solid #000;
        }

        .bill-summary-table .amount-col {
            text-align: right;
            font-weight: bold;
        }

        .bill-summary-table .total-row {
            background-color: #f2f2f2;
            font-size: 16px;
            font-weight: bold;
        }

        .weighings-breakdown-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .breakdown-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 30px;
        }

        .breakdown-table th {
            background-color: #eee;
            border: 1px solid #000;
            padding: 4px;
            font-weight: bold;
        }

        .breakdown-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        .signatures-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature-line {
            width: 28%;
            border-top: 1px solid #000;
            text-align: center;
            padding-top: 5px;
            font-size: 11px;
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
    
    <!-- Action Bar -->
    <div class="no-print" style="background: #f1f1f1; padding: 10px; text-align: center; border-bottom: 1px solid #ccc;">
        <button onclick="window.print();" style="padding: 8px 16px; font-weight: bold; background: #00007c; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Bill / Invoice
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
            <div class="slip-title">Vessel Unloading & Port Rent Invoice</div>
        </div>

        <!-- Meta Grid -->
        <table class="invoice-meta-table">
            <tr>
                <td class="label">Vessel Name</td>
                <td class="value" style="font-weight: bold;"><i class="bi bi-ship"></i> {{ $vessel->name }}</td>
                <td class="label">Invoice Date</td>
                <td class="value">{{ now()->format('Y-m-d h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Client / Owner</td>
                <td class="value" style="font-weight: bold;">{{ $vessel->party->name }}</td>
                <td class="label">Client Address</td>
                <td class="value">{{ $vessel->party->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Arrival Date</td>
                <td class="value">{{ $vessel->arrival_date ? $vessel->arrival_date->format('Y-m-d') : 'N/A' }}</td>
                <td class="label">Client Contacts</td>
                <td class="value">
                    Person: {{ $vessel->party->contact_person ?? 'N/A' }}<br>
                    Phone: {{ $vessel->party->contact_number ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="label">Unload Started</td>
                <td class="value text-success" style="font-weight: bold;">
                    {{ $vessel->unload_start_datetime ? $vessel->unload_start_datetime->format('Y-m-d h:i A') : 'N/A' }}
                </td>
                <td class="label">Unload Ended</td>
                <td class="value text-danger" style="font-weight: bold;">
                    {{ $vessel->unload_end_datetime ? $vessel->unload_end_datetime->format('Y-m-d h:i A') : 'N/A' }}
                </td>
            </tr>
        </table>

        <!-- Invoice Calculation Summary -->
        <h4 style="border-bottom: 1px solid #000; padding-bottom: 5px; margin-top: 10px;">Billing Summary</h4>
        <table class="bill-summary-table">
            <thead>
                <tr>
                    <th width="45%">Description</th>
                    <th width="15%" class="text-center">Rate (BDT)</th>
                    <th width="20%" class="text-center">Calculated Metrics</th>
                    <th width="20%" class="text-end">Total Charge</th>
                </tr>
            </thead>
            <tbody>
                <!-- Port Stay Rent -->
                <tr>
                    <td>
                        <strong>Port Stay Rent (Daily Rental Fee)</strong><br>
                        <small class="text-muted">Stay rent billed from start of unloading to completion timeframe.</small>
                    </td>
                    <td class="text-center">৳{{ number_format($vessel->daily_rent_rate, 2) }}</td>
                    <td class="text-center">{{ $vessel->stay_days }} Days</td>
                    <td class="amount-col">৳{{ number_format($vessel->rent_bill, 2) }}</td>
                </tr>
                <!-- Unloading Tonnage Cargo fee -->
                <tr>
                    <td>
                        <strong>Cargo Unloading Handling Charge</strong><br>
                        <small class="text-muted">Aggregated cargo tonnage weighed via trucks at ghat scale desk.</small>
                    </td>
                    <td class="text-center">৳{{ number_format($vessel->cargo_rate_per_ton, 2) }}</td>
                    <td class="text-center">{{ number_format($vessel->total_tonnage, 2) }} MT</td>
                    <td class="amount-col">৳{{ number_format($vessel->cargo_bill, 2) }}</td>
                </tr>
                <!-- Total Row -->
                <tr class="total-row">
                    <td colspan="3" class="text-end">Grand Total Bill (BDT)</td>
                    <td class="amount-col" style="color: #00007c; font-size: 18px;">৳{{ number_format($vessel->total_bill, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Weighings Audit Log Breakdown -->
        <div class="weighings-breakdown-title">
            Unloading Transaction Weight Logs Breakdown (Audit Trail)
        </div>
        <table class="breakdown-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Date/Time</th>
                    <th>Vehicle Plate</th>
                    <th>Challan Ref</th>
                    <th>Product</th>
                    <th>Gross Wt (kg)</th>
                    <th>Tare Wt (kg)</th>
                    <th>Net Payload (kg)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $allWeighings = $vessel->weighings()->completed()->orderBy('id')->get();
                @endphp
                @forelse($allWeighings as $w)
                    <tr>
                        <td>#{{ $w->ticket_number }}</td>
                        <td>{{ $w->first_weight_datetime->format('Y-m-d H:i') }}</td>
                        <td>{{ $w->vehicle->vehicle_number }}</td>
                        <td>{{ $w->challan_reference ?? '—' }}</td>
                        <td>{{ $w->product_name ?? '—' }}</td>
                        <td>{{ number_format($w->first_weight, 0) }}</td>
                        <td>{{ number_format($w->second_weight, 0) }}</td>
                        <td style="font-weight: bold;">{{ number_format($w->net_weight, 0) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-2" style="font-style: italic; color: #888;">
                            No truck weighings completed for this vessel.
                        </td>
                    </tr>
                @endforelse
                @if(count($allWeighings) > 0)
                    <tr style="background-color: #eee; font-weight: bold; font-size: 12px;">
                        <td colspan="7" class="text-end">Aggregate Weight Sum:</td>
                        <td>{{ number_format($vessel->weighings()->completed()->sum('net_weight'), 0) }} kg</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Signatures -->
        <div class="signatures-section">
            <div class="signature-line">Vessel Master / Agent</div>
            <div class="signature-line">Prepared By (Admin)</div>
            <div class="signature-line">Port Terminal Authority</div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
