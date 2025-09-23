@extends('frontend.layouts.app')

@section('title', 'My Account')

@section('content')
    <main class="main">
        <div class="page-content">
            <div class="container">
                <div class="account-dashboard">
                    <div class="row">
                        <div class="col-md-3">
                            @include('frontend.user.partials.sidebar')
                        </div>
                        <div class="col-md-9">
                            <div class="account-content">
                                <div class="welcome-section">
                                    <h2>Hello {{ Auth::user()->name }}!</h2>
                                    <p>From your account dashboard you can view your recent orders, manage your profile
                                        information.</p>
                                </div>

                                <div class="dashboard-stats">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-icon bg-primary">
                                                    <i class="icon-shopping-cart"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h3>{{ $stats['total_orders'] }}</h3>
                                                    <p>Total Orders</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-icon bg-warning">
                                                    <i class="icon-clock-o"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h3>{{ $stats['pending_orders'] }}</h3>
                                                    <p>Pending Orders</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-icon bg-success">
                                                    <i class="icon-check"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h3>{{ $stats['delivered_orders'] }}</h3>
                                                    <p>Delivered Orders</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-icon bg-info">
                                                    <i class="icon-dollar"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h3>${{ number_format($stats['total_spent'], 2) }}</h3>
                                                    <p>Total Spent</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user-dashboard.css') }}">
@endsection
