@extends('admin.layouts.app')

@section('content')
    <div class="container py-5">

        <h3 class="fw-bold mb-4">Manage Employers</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <form method="GET" class="row mb-4">

            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search name or email"
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <div class="col-md-2">
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-2">
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.users.employers.export') }}" class="btn btn-success">
                    Export CSV
                </a>
            </div>

        </form>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($employers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Suspended</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    @if ($user->is_active)
                                        <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-danger">
                                                Suspend
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.unsuspend', $user->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-success"
                                                onclick="return confirm('Are you sure you want to restore this account?')">
                                                Restore Account
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>


        <div class="row mb-4 py-5">

            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-0 rounded-4">
                    <h6>Employer Status</h6>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-0 rounded-4">
                    <h6>Monthly Growth</h6>
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Status Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Suspended'],
                datasets: [{
                    data: [{{ $activeCount }}, {{ $suspendedCount }}],
                    backgroundColor: ['#198754', '#dc3545']
                }]
            }
        });

        // Monthly Growth Chart
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyGrowth->keys()) !!},
                datasets: [{
                    label: 'New Employers',
                    data: {!! json_encode($monthlyGrowth->values()) !!},
                    borderColor: '#0d6efd',
                    fill: false,
                    tension: 0.3
                }]
            }
        });
    </script>
@endsection
