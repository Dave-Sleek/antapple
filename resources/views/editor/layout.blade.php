<ul class="nav flex-column gap-2">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.jobs.index') ? 'active fw-bold' : '' }}"
            href="{{ route('admin.jobs.index') }}">
            <i class="bi bi-briefcase me-2"></i> Jobs Overview
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active fw-bold' : '' }}"
            href="{{ route('admin.categories.index') }}">
            <i class="bi bi-tags me-2"></i> Manage Categories
        </a>
    </li>
</ul>
