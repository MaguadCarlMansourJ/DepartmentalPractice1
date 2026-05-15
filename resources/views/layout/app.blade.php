<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rice Shop Management System - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            padding-left: 25px;
        }
        .sidebar a.active {
            background: rgba(255,255,255,0.2);
            border-left: 4px solid white;
        }
        .content {
            padding: 20px;
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-top {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
    @stack('styles')
</head>
<body>
    @auth
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="text-center py-4">
                    <h4 class="text-white">Rice Shop MS</h4>
                    <small class="text-white-50">Welcome, {{ Auth::user()->name }}</small>
                </div>
                <nav>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-dashboard me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('rice-items.index') }}" class="{{ request()->routeIs('rice-items.*') ? 'active' : '' }}">
                        <i class="fas fa-rice me-2"></i> Rice Products
                    </a>
                    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart me-2"></i> Orders
                    </a>
                    <a href="{{ route('orders.create') }}" class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
                        <i class="fas fa-plus me-2"></i> New Order
                    </a>
                    <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.index') ? 'active' : '' }}">
                        <i class="fas fa-credit-card me-2"></i> Payments
                    </a>
                    <a href="{{ route('payments.unpaid') }}" class="{{ request()->routeIs('payments.unpaid') ? 'active' : '' }}">
                        <i class="fas fa-clock me-2"></i> Unpaid Orders
                    </a>
                    <hr class="bg-light">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </form>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-0">
                <nav class="navbar-top px-4 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">@yield('header')</h5>
                        <div>
                            <span class="text-muted">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </nav>
                <div class="content">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @else
        @yield('content')
    @endauth
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>