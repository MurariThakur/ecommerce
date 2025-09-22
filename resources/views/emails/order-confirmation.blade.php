<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
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

        .order-details {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .item:last-child {
            border-bottom: none;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
            color: #007bff;
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
            <h2>Order Confirmation</h2>
            <p>Thank you for your order!</p>
        </div>

        <div class="content">
            <h2>Hello {{ $order->first_name }} {{ $order->last_name }},</h2>
            <p>Your order has been confirmed and is being processed.</p>

            <div class="order-details">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>

            <div class="order-details">
                <h3>Items Ordered</h3>
                @foreach ($order->orderItems as $item)
                    <div class="item">
                        <strong>{{ $item->product->title }}</strong>
                        @if ($item->size)
                            <br>Size: {{ $item->size }}
                        @endif
                        @if ($item->color)
                            <br>Color: {{ $item->color }}
                        @endif
                        <br>Quantity: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                        <div style="text-align: right;"><strong>${{ number_format($item->total, 2) }}</strong></div>
                    </div>
                @endforeach
            </div>

            <div class="order-details">
                <h3>Shipping Address</h3>
                <p>{{ $order->first_name }} {{ $order->last_name }}</p>
                <p>{{ $order->address_line_1 }}</p>
                @if ($order->address_line_2)
                    <p>{{ $order->address_line_2 }}</p>
                @endif
                <p>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                <p>{{ $order->country }}</p>
            </div>

            <div class="order-details">
                <h3>Order Summary</h3>
                <p>Subtotal: ${{ number_format($order->total - $order->shipping_cost + $order->discount_amount, 2) }}
                </p>
                @if ($order->discount_amount > 0)
                    <p>Discount ({{ $order->discount_name }}): -${{ number_format($order->discount_amount, 2) }}</p>
                @endif
                <p>Shipping: ${{ number_format($order->shipping_cost, 2) }}</p>
                <p class="total">Total: ${{ number_format($order->total, 2) }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for shopping with {{ config('app.name') }}!</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>

</html>
