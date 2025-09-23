<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background: #f8f9fa;
        }

        .status-update {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            text-align: center;
        }

        .status {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .status.confirmed {
            color: #28a745;
        }

        .status.processing {
            color: #17a2b8;
        }

        .status.shipped {
            color: #007bff;
        }

        .status.delivered {
            color: #28a745;
        }

        .status.cancelled {
            color: #dc3545;
        }

        .order-details {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <h2>Order Status Update</h2>
        </div>

        <div class="content">
            <h2>Hello {{ $order->first_name }} {{ $order->last_name }},</h2>
            <p>Your order status has been updated.</p>

            <div class="status-update">
                <p>Order Number: <strong>{{ $order->order_number }}</strong></p>
                <div class="status {{ $order->status }}">{{ ucfirst($order->status) }}</div>
                @if ($order->status == 'shipped')
                    <p>Your order is on its way!</p>
                @elseif($order->status == 'delivered')
                    <p>Your order has been delivered. Thank you for shopping with us!</p>
                @elseif($order->status == 'cancelled')
                    <p>Your order has been cancelled. If you have any questions, please contact our support team.</p>
                @elseif($order->status == 'processing')
                    <p>Your order is being processed and will be shipped soon.</p>
                @endif
            </div>

            <div class="order-details">
                <h3>Order Summary</h3>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for shopping with {{ config('app.name') }}!</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>

</html>
