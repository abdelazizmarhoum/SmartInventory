<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://i.imgur.com/1hK5NqU.png" style="width:100%; max-width:300px;">
                            </td>
                            <td>
                                Invoice #: {{ $order->id }}<br>
                                Created: {{ $order->created_at->format('M d, Y') }}<br>
                                Due: {{ $order->order_date->format('M d, Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>From:</strong><br>
                                SmartInventory<br>
                                123 Your Street<br>
                                Your City, State, Zip Code
                            </td>
                            <td>
                                <strong>Bill To:</strong><br>
                                {{ $order->customer->name }}<br>
                                {{ $order->customer->address ?? 'N/A' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Unit Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
            @foreach($order->items as $item)
            <tr class="item">
                <td>{{ $item->product->name }}</td>
                <td>${{ number_format($item->price_at_time_of_purchase, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price_at_time_of_purchase * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total">
                <td colspan="3"></td>
                <td><strong>Total: ${{ number_format($order->total_amount, 2) }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>