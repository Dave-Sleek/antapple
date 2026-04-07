<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel — AntApple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .admin-sidebar {
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #eee;
        }

        .admin-sidebar .nav-link {
            color: #333;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }

        .admin-sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #000;
        }

        .admin-sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        /* Navbar styling */
        .navbar {
            padding: 0.75rem 1rem;
        }

        /* ===== RESET DROPDOWN STYLES ===== */
        .nav-item.dropdown .nav-link.dropdown-toggle {
            list-style: none !important;
        }

        .nav-item.dropdown .nav-link.dropdown-toggle::before,
        .nav-item.dropdown .nav-link.dropdown-toggle::after,
        .nav-item.dropdown .nav-link.dropdown-toggle>*:first-child::before,
        .nav-item.dropdown .nav-link.dropdown-toggle>*:first-child::after {
            display: none !important;
            content: none !important;
        }

        .nav-item.dropdown .nav-link.dropdown-toggle,
        .nav-item.dropdown .nav-link.dropdown-toggle * {
            list-style-type: none !important;
        }

        /* ===== NOTIFICATION TOGGLE ===== */
        .notification-toggle {
            position: relative;
            padding: 0.5rem !important;
            margin: 0 0.25rem;
            border-radius: 50%;
            transition: background-color 0.2s ease;
            text-decoration: none;
        }

        .notification-toggle::after {
            display: none !important;
            /* Removes Bootstrap dropdown chevron */
            content: none !important;
        }

        .notification-toggle:hover {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bell-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bell-container i {
            font-size: 1.4rem;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .notification-toggle:hover i {
            color: #10b981;
        }

        .notification-counter {
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 20px;
            height: 20px;
            background: linear-gradient(145deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            box-shadow: 0 3px 8px rgba(239, 68, 68, 0.4);
            border: 2px solid white;
        }

        /* ===== NOTIFICATION DROPDOWN ===== */
        .notification-menu {
            width: 360px;
            padding: 0 !important;
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
            overflow: hidden;
            margin-top: 0.75rem !important;
            animation: dropdown-appear 0.2s ease;
        }

        @keyframes dropdown-appear {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== NOTIFICATION HEADER ===== */
        .notification-header {
            padding: 1rem 1.25rem;
            background: #f8fafc;
            border-bottom: 1px solid #e9eef2;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-title i {
            color: #10b981;
            font-size: 1.1rem;
        }

        .header-title span {
            font-weight: 600;
            color: #1e2937;
            font-size: 0.95rem;
        }

        .unread-chip {
            background: #e2f3e4;
            color: #0b7b4b;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 30px;
            letter-spacing: 0.3px;
        }

        /* ===== NOTIFICATION LIST ===== */
        .notification-list {
            max-height: 340px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .notification-list::-webkit-scrollbar {
            width: 5px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* ===== NOTIFICATION ITEM ===== */
        .notification-item {
            padding: 1rem 1.25rem;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            text-decoration: none;
            border-bottom: 1px solid #f0f4f8;
            transition: background-color 0.15s ease;
            cursor: default;
        }

        .notification-item:hover {
            background-color: #fafdff;
        }

        .notification-item.unread {
            background-color: #f4faf7;
            position: relative;
        }

        .notification-item.unread::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #10b981;
            border-radius: 0 2px 2px 0;
        }

        /* Item Icon */
        .item-icon {
            width: 36px;
            height: 36px;
            background: #e8f3ef;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .item-icon i {
            color: #10b981;
            font-size: 1rem;
        }

        .unread .item-icon {
            background: #d9f0e5;
        }

        .unread .item-icon i {
            color: #0e7d4e;
        }

        /* Item Content */
        .item-content {
            flex: 1;
            min-width: 0;
        }

        .item-message {
            color: #1e2937;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 0.35rem;
            font-weight: 400;
            word-wrap: break-word;
        }

        .unread .item-message {
            font-weight: 500;
            color: #0b2e1f;
        }

        .item-time {
            color: #8a9aa8;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .item-time::before {
            content: '•';
            color: #cbd5e1;
            font-size: 0.8rem;
            margin-right: 0.2rem;
        }

        /* Unread Dot */
        .item-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            margin-top: 0.3rem;
            flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.15);
        }

        /* ===== EMPTY STATE ===== */
        .notification-empty {
            padding: 2.5rem 1.5rem;
            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            background: #f3f6f9;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .empty-icon i {
            font-size: 2.2rem;
            color: #a7b8c7;
        }

        .empty-title {
            color: #1e2937;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .empty-text {
            color: #8698a8;
            font-size: 0.85rem;
        }

        /* ===== NOTIFICATION FOOTER ===== */
        .notification-footer {
            padding: 0.85rem 1.25rem;
            background: #f9fbfd;
            border-top: 1px solid #e9eef2;
            text-align: center;
        }

        .view-all {
            color: #10b981;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            cursor: default;
            transition: gap 0.2s ease;
        }

        .view-all i {
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }

        .view-all:hover {
            gap: 0.6rem;
        }

        .view-all:hover i {
            transform: translateX(3px);
        }

        /* ===== RESPONSIVE ADJUSTMENTS ===== */
        @media (max-width: 576px) {
            .notification-menu {
                width: 320px;
                position: fixed !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
            }
        }

        /* User info styling */
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            background: #f8f9fa;
            border-radius: 40px;
        }

        .user-info i {
            color: #6c757d;
        }

        .user-role {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #10b981;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('admin.jobs.index') }}">
                <i class="bi bi-grid-fill me-2" style="color: #10b981;"></i>
                AntApple Admin
            </a>

            <div class="d-flex align-items-center gap-3">
                {{-- NOTIFICATION BELL --}}
                @auth
                    <li class="nav-item dropdown" style="list-style: none;">
                        <a class="nav-link notification-toggle" data-bs-toggle="dropdown" role="button"
                            aria-expanded="false">
                            <div class="bell-container">
                                <i class="bi bi-bell"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span class="notification-counter">
                                        {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end notification-menu">
                            <div class="notification-header">
                                <div class="header-title">
                                    <i class="bi bi-bell-fill"></i>
                                    <span>Notifications</span>
                                </div>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span class="unread-chip">{{ auth()->user()->unreadNotifications->count() }} new</span>
                                @endif
                            </div>

                            <div class="notification-list">
                                @forelse(auth()->user()->notifications->take(5) as $notification)
                                    <form action="{{ route('notifications.read.single', $notification->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item notification-item {{ $notification->read_at ? '' : 'unread' }}">
                                            <div class="item-icon">
                                                <i class="bi bi-bell"></i>
                                            </div>
                                            <div class="item-content">
                                                <div class="item-message">
                                                    {{ $notification->data['message'] ?? 'New notification' }}
                                                </div>
                                                <div class="item-time">{{ $notification->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            @if (!$notification->read_at)
                                                <span class="item-dot"></span>
                                            @endif
                                        </button>
                                    </form>
                                @empty
                                    <div class="notification-empty">
                                        <div class="empty-icon">
                                            <i class="bi bi-bell-slash"></i>
                                        </div>
                                        <div class="empty-title">No notifications</div>
                                        <div class="empty-text">You're all caught up!</div>
                                    </div>
                                @endforelse
                            </div>

                            @if (auth()->user()->notifications->count() > 5)
                                <div class="notification-footer">
                                    <a href="/notifications" class="view-all">
                                        View all notifications <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </li>
                @endauth

                {{-- User Info --}}
                <div class="user-info">
                    <i class="bi bi-person-circle"></i>
                    <div class="d-flex flex-column">
                        <span class="small fw-bold">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->role }}</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <aside class="col-md-2 admin-sidebar bg-light border-end vh-100 p-3 d-flex flex-column">
                <h5 class="mb-4 text-center fw-bold">Admin Panel</h5>
                <ul class="nav flex-column gap-2">

                    @php
                        $adminLinks = [
                            ['route' => 'admin.dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
                            ['route' => 'admin.jobs.pending', 'icon' => 'bi-clock', 'label' => 'Pending Jobs'],
                            ['route' => 'admin.jobs.index', 'icon' => 'bi-briefcase', 'label' => 'Jobs'],
                            ['route' => 'admin.users.employers', 'icon' => 'bi-people', 'label' => 'Manage Employers'],
                            [
                                'route' => 'admin.users.index',
                                'icon' => 'bi-person-lines-fill',
                                'label' => 'Manage Users',
                            ],
                            [
                                'route' => 'admin.revenue.payments',
                                'icon' => 'bi-currency-dollar',
                                'label' => 'Revenue & Payments',
                            ],
                            [
                                'route' => 'admin.reports.index',
                                'icon' => 'bi-file-earmark-text',
                                'label' => 'Manage Reports',
                            ],
                            ['route' => 'admin.plans.index', 'icon' => 'bi-card-list', 'label' => 'Manage Plans'],
                            ['route' => 'admin.contacts.index', 'icon' => 'bi-envelope', 'label' => 'Contact Messages'],
                            ['route' => 'admin.user_logs.index', 'icon' => 'bi-shield', 'label' => 'User Logs'],
                            ['route' => 'admin.system-status', 'icon' => 'bi-cpu', 'label' => 'System Monitor'],
                            ['route' => 'admin.system.status', 'icon' => 'bi-database', 'label' => 'Database Monitor'],
                        ];
                    @endphp

                    @foreach ($adminLinks as $link)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center {{ request()->routeIs($link['route'] . '*') ? 'active fw-bold' : '' }}"
                                href="{{ route($link['route']) }}">
                                <i class="bi {{ $link['icon'] }} me-2"></i>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach

                </ul>

                {{-- Optional: Logout button at bottom --}}

                <div class="mt-auto pt-3 border-top">
                    <a class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="col-md-10 p-4">
                @yield('content')
            </main>
        </div>
    </div>


    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // Initialize CKEditor on your textarea
        CKEDITOR.replace('descriptionEditor', {
            height: 300,
            removePlugins: 'elementspath',
            resize_enabled: false,
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'document',
                    items: ['Source']
                }
            ]
        });

        CKEDITOR.replace('aboutCompanyEditor', {
            height: 300,
            removePlugins: 'elementspath',
            resize_enabled: false,
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'document',
                    items: ['Source']
                }
            ]
        });
    </script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
