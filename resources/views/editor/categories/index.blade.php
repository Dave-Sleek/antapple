@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">

        {{-- Premium Header --}}
        <div class="categories-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-tags"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <div>
                            <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-grid me-2"></i>CLASSIFICATION
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Job <span
                                    class="text-gradient">Categories</span></h1>
                            <p class="text-muted lead mb-0">Organize and manage job categories for the platform</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stats-bubbles">
                        <div class="stat-bubble">
                            <span class="stat-number">{{ $categories->count() }}</span>
                            <span class="stat-label">Total Categories</span>
                        </div>
                        <div class="stat-bubble">
                            @php
                                $activeCount = $categories->where('is_active', true)->count();
                            @endphp
                            <span class="stat-number">{{ $activeCategories }}</span>
                            <span class="stat-label">Active Categories</span>
                        </div>
                        <div class="stat-bubble">
                            <span class="stat-number">{{ $categories->sum('jobs_count') ?? 0 }}</span>
                            <span class="stat-label">Jobs Linked</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Add Category Form --}}
            <div class="col-lg-5">
                <div class="add-category-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle"></i>
                            <h5 class="fw-bold mb-0">Create New Category</h5>
                        </div>
                        <p class="header-subtitle">Add a new job category to the system</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categories.store') }}" id="categoryForm">
                            @csrf
                            <div class="premium-input">
                                <div class="input-wrapper">
                                    <i class="bi bi-tag"></i>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="e.g., Technology, Healthcare, Finance" required id="categoryName">
                                </div>
                                <div class="input-hint">
                                    <i class="bi bi-info-circle"></i>
                                    <span>Category name should be unique and descriptive</span>
                                </div>
                            </div>

                            <div class="form-options">
                                <div class="premium-toggle">
                                    <label class="toggle-label">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-eye"></i>
                                            <span>Active</span>
                                        </div>
                                        <div class="toggle-wrapper">
                                            <input type="checkbox" name="is_active" value="1" checked>
                                            <span class="toggle-slider"></span>
                                        </div>
                                    </label>
                                </div>

                                <div class="premium-input">
                                    <div class="input-wrapper">
                                        <i class="bi bi-palette"></i>
                                        <select name="color" class="form-select" id="categoryColor">
                                            <option value="#10b981">Green</option>
                                            <option value="#3b82f6">Blue</option>
                                            <option value="#8b5cf6">Purple</option>
                                            <option value="#f59e0b">Orange</option>
                                            <option value="#ef4444">Red</option>
                                            <option value="#ec4899">Pink</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-submit">
                                <span class="btn-text">Create Category</span>
                                <i class="bi bi-plus-lg ms-2"></i>
                                <div class="btn-glow"></div>
                            </button>
                        </form>

                        {{-- Preview --}}
                        <div class="preview-section mt-4">
                            <div class="preview-label">Preview</div>
                            <div class="preview-badge" id="previewBadge">
                                <i class="bi bi-tag-fill"></i>
                                <span id="previewText">Category Name</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Categories List --}}
            <div class="col-lg-7">
                <div class="categories-list-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-list-ul"></i>
                            <h5 class="fw-bold mb-0">All Categories</h5>
                        </div>
                        <div class="header-actions">
                            <div class="search-wrapper">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchCategory" class="search-input"
                                    placeholder="Search categories...">
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if ($categories->count())
                            <div class="categories-grid" id="categoriesGrid">
                                @foreach ($categories as $category)
                                    <div class="category-item" data-name="{{ strtolower($category->name) }}">
                                        <div class="category-info">
                                            <div class="category-icon"
                                                style="background: {{ $category->color ?? '#10b981' }}20;">
                                                <i class="bi bi-tag-fill"
                                                    style="color: {{ $category->color ?? '#10b981' }};"></i>
                                            </div>
                                            <div>
                                                <div class="category-name">{{ $category->name }}</div>
                                                <div class="category-meta">
                                                    <span class="jobs-count">
                                                        <i class="bi bi-briefcase"></i>
                                                        {{ $category->jobs_count ?? 0 }} jobs
                                                    </span>
                                                    <span
                                                        class="status-badge {{ $category->is_active ? 'active' : 'inactive' }}">
                                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="category-actions">
                                            <button class="action-btn edit"
                                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}', {{ $category->is_active ? 'true' : 'false' }}, '{{ $category->color ?? '#10b981' }}')"
                                                title="Edit Category">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('categories.destroy', $category->id) }}"
                                                method="POST" class="delete-form d-inline"
                                                onsubmit="return confirm('Delete this category? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Delete Category">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Empty Search State --}}
                            <div id="noResults" class="no-results" style="display: none;">
                                <div class="empty-icon">
                                    <i class="bi bi-search"></i>
                                </div>
                                <p>No categories found matching your search</p>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-tags"></i>
                                </div>
                                <p class="empty-text">No categories yet</p>
                                <p class="empty-subtext">Create your first category using the form</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div class="modal fade premium-modal" id="editCategoryModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modal-header-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold">Edit Category</h5>
                                <p class="modal-subtitle">Update category details</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="premium-input">
                                <div class="input-wrapper">
                                    <i class="bi bi-tag"></i>
                                    <input type="text" name="name" id="editCategoryName" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="form-options mt-3">
                                <div class="premium-toggle">
                                    <label class="toggle-label">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-eye"></i>
                                            <span>Active</span>
                                        </div>
                                        <div class="toggle-wrapper">
                                            <input type="checkbox" name="is_active" id="editCategoryActive"
                                                value="1">
                                            <span class="toggle-slider"></span>
                                        </div>
                                    </label>
                                </div>

                                <div class="premium-input">
                                    <div class="input-wrapper">
                                        <i class="bi bi-palette"></i>
                                        <select name="color" id="editCategoryColor" class="form-select">
                                            <option value="#10b981">Green</option>
                                            <option value="#3b82f6">Blue</option>
                                            <option value="#8b5cf6">Purple</option>
                                            <option value="#f59e0b">Orange</option>
                                            <option value="#ef4444">Red</option>
                                            <option value="#ec4899">Pink</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="preview-section mt-3">
                                <div class="preview-label">Preview</div>
                                <div class="preview-badge" id="editPreviewBadge">
                                    <i class="bi bi-tag-fill"></i>
                                    <span id="editPreviewText">Category Name</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Categories Management Styles */

    /* Header */
    .categories-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 32px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .header-icon-wrapper {
        position: relative;
    }

    .header-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        position: relative;
        z-index: 2;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .header-icon-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
        filter: blur(15px);
        opacity: 0.5;
        animation: pulse 2s infinite;
        z-index: 1;
    }

    .header-icon-ring {
        position: absolute;
        top: -15px;
        left: -15px;
        right: -15px;
        bottom: -15px;
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 32px;
        animation: ring 3s infinite;
        z-index: 1;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.5;
            transform: scale(1);
        }

        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }

    @keyframes ring {
        0% {
            transform: scale(1);
            opacity: 0.5;
        }

        50% {
            transform: scale(1.2);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 0.5;
        }
    }

    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Stats Bubbles */
    .stats-bubbles {
        display: flex;
        justify-content: flex-end;
        gap: 1.5rem;
    }

    .stat-bubble {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 1.8rem;
        font-weight: 800;
        color: #10b981;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
    }

    /* Add Category Card */
    .add-category-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .add-category-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .add-category-card .card-header i {
        color: #10b981;
        font-size: 1.2rem;
    }

    .header-subtitle {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .add-category-card .card-body {
        padding: 1.5rem;
    }

    /* Premium Input */
    .premium-input {
        margin-bottom: 1.5rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
        transition: color 0.3s ease;
    }

    .premium-input .form-control,
    .premium-input .form-select {
        height: 52px;
        padding: 0 16px 0 48px;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .premium-input .form-control:focus,
    .premium-input .form-select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: white;
    }

    .premium-input:focus-within i {
        color: #10b981;
    }

    .input-hint {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Form Options */
    .form-options {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-options .premium-input {
        flex: 1;
        margin-bottom: 0;
    }

    /* Premium Toggle */
    .premium-toggle {
        background: #f8fafc;
        padding: 0.75rem 1rem;
        border-radius: 60px;
        border: 1px solid #e2e8f0;
    }

    .toggle-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        margin: 0;
    }

    .toggle-wrapper {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
    }

    .toggle-wrapper input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e2e8f0;
        transition: 0.3s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .toggle-wrapper input:checked+.toggle-slider {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .toggle-wrapper input:checked+.toggle-slider:before {
        transform: translateX(24px);
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
    }

    .btn-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .btn-submit:hover .btn-glow {
        opacity: 1;
    }

    /* Preview Section */
    .preview-section {
        background: #f8fafc;
        border-radius: 20px;
        padding: 1rem;
        text-align: center;
    }

    .preview-label {
        font-size: 0.75rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .preview-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(16, 185, 129, 0.1);
        border-radius: 60px;
        color: #10b981;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Categories List Card */
    .categories-list-card {
        background: white;
        border-radius: 28px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .categories-list-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .categories-list-card .card-header i {
        color: #10b981;
        font-size: 1.2rem;
    }

    .search-wrapper {
        position: relative;
    }

    .search-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-input {
        height: 44px;
        width: 250px;
        padding: 0 16px 0 48px;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Categories Grid */
    .categories-grid {
        max-height: 500px;
        overflow-y: auto;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .category-item:hover {
        background: #f8fafc;
    }

    .category-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .category-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .category-name {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 0.25rem;
    }

    .category-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .jobs-count {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        color: #64748b;
    }

    .jobs-count i {
        color: #10b981;
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .status-badge.active {
        background: #d1fae5;
        color: #047857;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Category Actions */
    .category-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .action-btn.edit:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
    }

    .action-btn.delete:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state,
    .no-results {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f8fafc;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .empty-icon i {
        font-size: 2.5rem;
        color: #94a3b8;
    }

    .empty-text {
        font-weight: 500;
        color: #1e2937;
        margin-bottom: 0.25rem;
    }

    .empty-subtext {
        font-size: 0.85rem;
        color: #94a3b8;
    }

    /* Premium Modal */
    .premium-modal .modal-content {
        border: none;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
    }

    .premium-modal .modal-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .modal-header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: white;
    }

    .modal-subtitle {
        color: #64748b;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .premium-modal .modal-body {
        padding: 1.5rem;
    }

    .premium-modal .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        gap: 1rem;
    }

    .btn-secondary {
        padding: 10px 24px;
        border-radius: 60px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: #10b981;
        color: #10b981;
    }

    .btn-primary {
        padding: 10px 24px;
        border-radius: 60px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .stats-bubbles {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .form-options {
            flex-direction: column;
        }

        .categories-list-card .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-input {
            width: 100%;
        }
    }
</style>

<script>
    // Preview functionality
    const categoryName = document.getElementById('categoryName');
    const previewText = document.getElementById('previewText');
    const categoryColor = document.getElementById('categoryColor');
    const previewBadge = document.getElementById('previewBadge');

    categoryName?.addEventListener('input', function() {
        const value = this.value || 'Category Name';
        previewText.textContent = value;
    });

    categoryColor?.addEventListener('change', function() {
        const color = this.value;
        previewBadge.style.background = `${color}20`;
        previewBadge.style.color = color;
        previewBadge.querySelector('i').style.color = color;
    });

    // Search functionality
    const searchInput = document.getElementById('searchCategory');
    const categoriesGrid = document.getElementById('categoriesGrid');
    const noResults = document.getElementById('noResults');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('.category-item');
            let visibleCount = 0;

            items.forEach(item => {
                const name = item.dataset.name;
                if (name.includes(searchTerm)) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
    }

    // Edit category
    function editCategory(id, name, isActive, color) {
        const form = document.getElementById('editCategoryForm');
        form.action = `/editor/categories/${id}`;

        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryActive').checked = isActive;
        document.getElementById('editCategoryColor').value = color;

        // Update preview
        const editPreviewText = document.getElementById('editPreviewText');
        const editPreviewBadge = document.getElementById('editPreviewBadge');
        editPreviewText.textContent = name;
        editPreviewBadge.style.background = `${color}20`;
        editPreviewBadge.style.color = color;
        editPreviewBadge.querySelector('i').style.color = color;

        const modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        modal.show();
    }

    // Edit preview
    const editCategoryName = document.getElementById('editCategoryName');
    const editPreviewText = document.getElementById('editPreviewText');
    const editCategoryColor = document.getElementById('editCategoryColor');
    const editPreviewBadge = document.getElementById('editPreviewBadge');

    editCategoryName?.addEventListener('input', function() {
        const value = this.value || 'Category Name';
        editPreviewText.textContent = value;
    });

    editCategoryColor?.addEventListener('change', function() {
        const color = this.value;
        editPreviewBadge.style.background = `${color}20`;
        editPreviewBadge.style.color = color;
        editPreviewBadge.querySelector('i').style.color = color;
    });

    // Form submission animation
    document.getElementById('categoryForm')?.addEventListener('submit', function(e) {
        const btn = this.querySelector('.btn-submit');
        btn.classList.add('loading');
        btn.querySelector('.btn-text').style.opacity = '0';

        // Add spinner
        const spinner = document.createElement('span');
        spinner.className = 'spinner';
        spinner.innerHTML = '<i class="bi bi-arrow-repeat spinning"></i>';
        btn.appendChild(spinner);
    });
</script>
