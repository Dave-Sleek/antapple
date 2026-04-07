@extends('admin.layouts.app')

@section('content')
    <div class="container py-5">

        <h2 class="fw-bold mb-4">Admin Analytics Dashboard</h2>

        {{-- Analytics Cards --}}
        <div class="row g-4 mb-5">

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <small class="text-muted">Total Jobs</small>
                    <h3 class="fw-bold">{{ $totalJobs }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <small class="text-muted">Pending Jobs</small>
                    <h3 class="fw-bold text-warning">{{ $TotalpendingJobs }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <small class="text-muted">Approved Jobs</small>
                    <h3 class="fw-bold text-success">{{ $approvedJobs }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <small class="text-muted">Total Employers</small>
                    <h3 class="fw-bold">{{ $totalEmployers }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <small class="text-muted">Total Applicants</small>
                    <h3 class="fw-bold">{{ $totalApplicants }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <small class="text-muted">Total Revenue</small>
                    <h3 class="fw-bold text-primary">
                        ₦{{ number_format($totalRevenue, 2) }}
                    </h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <small class="text-muted">Featured Jobs</small>
                    <h2 class="fw-bold text-success mt-2">
                        {{ $TotalFeaturedJobs }}
                    </h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <small class="text-muted">Total Platform Views</small>
                    <h2 class="fw-bold text-primary mt-2">
                        {{ number_format($totalViews) }}
                    </h2>
                    <span class="stat-trend">
                        {{ $uniqueViewers ?? 0 }} unique viewers
                    </span>
                </div>
            </div>

            {{-- @foreach ($topJobs as $job)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <small class="text-muted">Total Platform Views</small>
                        <span>{{ $job->title }}</span>
                        <span>{{ number_format($job->views_count) }}</span>
                    </div>
                </div>
            @endforeach --}}

        </div>


        <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="card shadow p-3">
                    <h6>Total Revenue</h6>
                    <h3 id="revenueCounter">₦0</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow p-3">
                    <h6>Active Jobs</h6>
                    <h3 id="approvedCounter">0</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow p-3">
                    <h6>Pending Jobs</h6>
                    <h3 id="pendingCounter">0</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow p-3">
                    <h6>Employers</h6>
                    <h3 id="employerCounter">0</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="employerChart"></canvas>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card shadow p-3">
                    <h5 class="text-center">Job Status Overview</h5>
                    <canvas id="jobStatusChart"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow p-3">
                    <h5 class="text-center">Revenue (Last 6 Months)</h5>
                    <canvas id="revenue_Chart"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow p-3">
                    <h5 class="text-center">Jobs Posted (Last 6 Months)</h5>
                    <canvas id="jobsChart"></canvas>
                </div>
            </div>
        </div>

        <br />
        {{-- Recent Jobs --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4 py-5">
            <div class="card-header bg-white fw-bold">
                Recent Job Posts
            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recentJobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->company_name }}</td>
                                <td>
                                    @if ($job->status == 'active')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($job->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Reject</span>
                                    @endif
                                </td>
                                <td>{{ $job->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No jobs yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Job Status Pie Chart
        new Chart(document.getElementById('jobStatusChart'), {
            type: 'pie',
            data: {
                labels: ['Active', 'Pending', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $approvedJobs }},
                        {{ $TotalpendingJobs }},
                        {{ $rejectedJobs }}
                    ],
                    backgroundColor: ['#198754', '#ffc107', '#dc3545']
                }]
            }
        });

        // Revenue Line Chart
        new Chart(document.getElementById('revenue_Chart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyRevenue->keys()) !!},
                datasets: [{
                    label: 'Revenue (₦)',
                    data: {!! json_encode($monthlyRevenue->values()) !!},
                    borderColor: '#198754',
                    fill: false,
                    tension: 0.3
                }]
            }
        });

        // Jobs Bar Chart
        new Chart(document.getElementById('jobsChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyJobs->keys()) !!},
                datasets: [{
                    label: 'Jobs Posted',
                    data: {!! json_encode($monthlyJobs->values()) !!},
                    backgroundColor: '#0d6efd'
                }]
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let revenueChart, employerChart;

        function animateCounter(id, endValue, prefix = '') {
            let element = document.getElementById(id);
            let start = 0;
            let duration = 800;
            let stepTime = Math.abs(Math.floor(duration / endValue));
            let timer = setInterval(function() {
                start += Math.ceil(endValue / 50);
                if (start >= endValue) {
                    start = endValue;
                    clearInterval(timer);
                }
                element.innerText = prefix + start.toLocaleString();
            }, 20);
        }

        function loadDashboardStats() {
            fetch("{{ route('admin.dashboard.stats') }}")
                .then(response => response.json())
                .then(data => {

                    // Animate counters
                    animateCounter('revenueCounter', data.totalRevenue, '₦');
                    animateCounter('approvedCounter', data.approvedJobs);
                    animateCounter('pendingCounter', data.pendingJobs);
                    animateCounter('employerCounter', data.totalEmployers);

                    // Revenue Chart
                    if (revenueChart) revenueChart.destroy();
                    revenueChart = new Chart(document.getElementById('revenueChart'), {
                        type: 'line',
                        data: {
                            labels: Object.keys(data.monthlyRevenue),
                            datasets: [{
                                label: 'Monthly Revenue',
                                data: Object.values(data.monthlyRevenue),
                                borderColor: '#198754',
                                fill: false
                            }]
                        }
                    });

                    // Employer Growth Chart
                    if (employerChart) employerChart.destroy();
                    employerChart = new Chart(document.getElementById('employerChart'), {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data.employerGrowth),
                            datasets: [{
                                label: 'New Employers',
                                data: Object.values(data.employerGrowth),
                                backgroundColor: '#0d6efd'
                            }]
                        }
                    });
                });
        }

        // Initial load
        loadDashboardStats();

        // Auto update every 10 seconds
        setInterval(loadDashboardStats, 10000);
    </script>
@endsection
