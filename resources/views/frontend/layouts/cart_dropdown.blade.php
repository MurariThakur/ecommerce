@if (Cart::isEmpty())
    <p class="text-center p-3">Your cart is empty</p>
@else
    <div class="dropdown-cart-products" id="dropdown-cart-products">
        @foreach (Cart::getContent() as $item)
            <div class="product d-flex align-items-center" id="dropdown-item-{{ $item->id }}">
                <div class="product-cart-details flex-grow-1">
                    <h6 class="product-title">
                        <a href="#">{{ $item->name }}</a>
                    </h6>

                    {{-- Color & Size --}}
                    @if ($item->attributes->color || $item->attributes->size)
                        <div class="d-flex align-items-center flex-wrap small text-muted">
                            @if ($item->attributes->color)
                                <span class="d-inline-block rounded-circle me-2 border"
                                    style="width:15px; height:15px; background: {{ $item->attributes->color }}">
                                </span>
                                <span
                                    style="font-size: 1.5rem;padding-left:0.5rem">{{ ucfirst($item->attributes->color) }}</span>
                            @endif

                            @if ($item->attributes->size)
                                <span style="padding-left: 1.5rem;font-size: 1.3rem">Size:
                                    <strong>{{ strtoupper($item->attributes->size) }}</strong></span>
                            @endif
                        </div>
                    @endif

                    <div>
                        <span class="fw-semibold">{{ $item->quantity }}</span>
                        <span class="text-muted">x</span>
                        <span class="fw-semibold">${{ number_format($item->price, 2) }}</span>
                    </div>
                </div>

                <figure class="product-image-container ms-3">
                    <a href="#" class="product-image">
                        <img src="{{ $item->attributes->image }}" alt="{{ $item->name }}" class="img-fluid"
                            style="width: 50px;">
                    </a>
                </figure>

                <a href="#" class="btn-remove text-danger ms-2 remove-item-dropdown"
                    data-rowid="{{ $item->id }}" title="Remove Product">
                    <i class="icon-close"></i>
                </a>
            </div>
        @endforeach
    </div>

    <div class="dropdown-cart-total">
        <span>Total</span>
        <span class="cart-total-price" id="dropdown-cart-total">
            ${{ number_format(Cart::getTotal(), 2) }}
        </span>
    </div>

    <div class="dropdown-cart-action">
        <a href="{{ route('cart.index') }}" class="btn btn-primary">View Cart</a>
        <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2">
            <span>Checkout</span>
            <i class="icon-long-arrow-right"></i>
        </a>
    </div>
@endif
