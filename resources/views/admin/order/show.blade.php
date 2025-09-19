@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Order Management</a></li>
                            <li class="breadcrumb-item active">Order Details</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Order Information -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Order Information</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.order.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Back to Orders
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Order Number:</strong></td>
                                                <td>{{ $order->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Date:</strong></td>
                                                <td>{{ $order->created_at->format('M d, Y H:i:s') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Status:</strong></td>
                                                <td>
                                                    @switch($order->status)
                                                        @case('confirmed')
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Confirmed
                                                            </span>
                                                        @break

                                                        @case('processing')
                                                            <span class="badge badge-info">
                                                                <i class="fas fa-cog"></i> Processing
                                                            </span>
                                                        @break

                                                        @case('shipped')
                                                            <span class="badge badge-primary">
                                                                <i class="fas fa-shipping-fast"></i> Shipped
                                                            </span>
                                                        @break

                                                        @case('delivered')
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check"></i> Delivered
                                                            </span>
                                                        @break

                                                        @case('cancelled')
                                                            <span class="badge badge-danger">
                                                                <i class="fas fa-ban"></i> Cancelled
                                                            </span>
                                                        @break

                                                        @default
                                                            <span class="badge badge-secondary">Unknown</span>
                                                    @endswitch
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Status:</strong></td>
                                                <td>
                                                    @if ($order->is_payment)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> Paid
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle"></i> Unpaid
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Method:</strong></td>
                                                <td>{{ ucfirst($order->payment_method) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Total Amount:</strong></td>
                                                <td>
                                                    <h4 class="text-success">${{ number_format($order->total, 2) }}</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shipping Cost:</strong></td>
                                                <td>${{ number_format($order->shipping_cost, 2) }}</td>
                                            </tr>
                                            @if ($order->discount_amount > 0)
                                                <tr>
                                                    <td><strong>Discount:</strong></td>
                                                    <td>
                                                        {{ $order->discount_name }}
                                                        <span
                                                            class="text-success">(-${{ number_format($order->discount_amount, 2) }})</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td><strong>Shipping Method:</strong></td>
                                                <td>{{ $order->shipping_method_name ?? $order->shipping_method }}</td>
                                            </tr>
                                            @if ($order->discount_name)
                                                <tr>
                                                    <td><strong>Discount Name:</strong></td>
                                                    <td>{{ $order->discount_name }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customer Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Billing Information</h5>
                                        <address>
                                            <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                                            @if ($order->company)
                                                {{ $order->company }}<br>
                                            @endif
                                            {{ $order->address_line_1 }}<br>
                                            @if ($order->address_line_2)
                                                {{ $order->address_line_2 }}<br>
                                            @endif
                                            {{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>
                                            {{ $order->country }}<br>
                                            <strong>Phone:</strong> {{ $order->phone }}<br>
                                            <strong>Email:</strong> {{ $order->email }}
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($order->user)
                                            <h5>Registered Customer</h5>
                                            <p><strong>Customer ID:</strong> {{ $order->user->id }}</p>
                                            <p><strong>Registration Date:</strong>
                                                {{ $order->user->created_at->format('M d, Y') }}</p>
                                        @else
                                            <h5>Guest Customer</h5>
                                            <p>This order was placed by a guest customer.</p>
                                        @endif

                                        @if ($order->notes)
                                            <h5>Order Notes</h5>
                                            <p class="text-muted">{{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Order Items</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->product && $item->product->productImages->first())
                                                        <img src="{{ $item->product->productImages->first()->image_url }}"
                                                            alt="Product Image" class="img-thumbnail"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px; border-radius: 4px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $item->product->title ?? 'Product Not Found' }}</strong>
                                                    @if ($item->product)
                                                        <br><small class="text-muted">SKU:
                                                            {{ $item->product->sku ?? 'N/A' }}</small>
                                                        <br><button type="button" class="btn btn-sm btn-outline-info"
                                                            data-toggle="modal"
                                                            data-target="#productModal{{ $item->id }}">
                                                            <i class="fas fa-info-circle"></i> Details
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>{{ $item->color ?? 'N/A' }}</td>
                                                <td>{{ $item->size ?? 'N/A' }}</td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td><strong>${{ number_format($item->total, 2) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th colspan="6" class="text-right">Subtotal:</th>
                                            <th>${{ number_format($order->orderItems->sum('total'), 2) }}</th>
                                        </tr>
                                        @if ($order->discount_amount > 0)
                                            <tr class="bg-light">
                                                <th colspan="6" class="text-right">Discount:</th>
                                                <th class="text-success">-${{ number_format($order->discount_amount, 2) }}
                                                </th>
                                            </tr>
                                        @endif
                                        <tr class="bg-light">
                                            <th colspan="6" class="text-right">Shipping:</th>
                                            <th>${{ number_format($order->shipping_cost, 2) }}</th>
                                        </tr>
                                        <tr class="bg-primary text-white">
                                            <th colspan="6" class="text-right">Total:</th>
                                            <th>${{ number_format($order->total, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        @if ($order->payment_data)
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Payment Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <pre class="bg-light p-3 rounded">{{ json_encode($order->payment_data, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- Product Details Modals -->
    @foreach ($order->orderItems as $item)
        @if ($item->product)
            <div class="modal fade" id="productModal{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="productModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel{{ $item->id }}">
                                <i class="fas fa-box text-info"></i>
                                Product Details
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-outline card-info mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">Order Item Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @if ($item->product->productImages->first())
                                                <img src="{{ $item->product->productImages->first()->image_url }}"
                                                    alt="Product Image" class="img-fluid rounded"
                                                    style="max-height: 200px; width: 100%; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                    style="height: 200px;">
                                                    <i class="fas fa-image fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Ordered Product:</strong></td>
                                                    <td>{{ $item->product->title }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Color:</strong></td>
                                                    <td>{{ $item->color ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Size:</strong></td>
                                                    <td>{{ $item->size ?? 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Order Price:</strong></td>
                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Quantity:</strong></td>
                                                    <td>{{ $item->quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Item Total:</strong></td>
                                                    <td><strong>${{ number_format($item->total, 2) }}</strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-outline card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Current Product Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Product Name:</strong></td>
                                                    <td>{{ $item->product->title }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>SKU:</strong></td>
                                                    <td>{{ $item->product->sku ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Category:</strong></td>
                                                    <td>{{ $item->product->category->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Subcategory:</strong></td>
                                                    <td>{{ $item->product->subcategory->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Brand:</strong></td>
                                                    <td>{{ $item->product->brand->name ?? 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        @if ($item->product->status)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created:</strong></td>
                                                    <td>{{ $item->product->created_at->format('M d, Y') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    @if ($item->product->short_description)
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h6><strong>Description:</strong></h6>
                                                <p class="text-muted">{{ $item->product->short_description }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
