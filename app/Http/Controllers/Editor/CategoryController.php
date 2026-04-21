<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job_post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with job counts
     */
    public function index()
    {
        // Get categories with active job counts
        $categories = Category::withCount([
            'jobs' => function($query) {
                $query->where('status', 'active');
            }
        ])->orderBy('name')->get();

        // Get total jobs count for statistics
        $totalJobs = Job_post::where('status', 'active')->count();

        // ✅ Added job counts to categories
        $categories = Category::withCount([
            'jobs' => function($query) {
                $query->where('status', 'active');
            }
        ])->orderBy('name')->get();
       
        // Count categories with active job posts only
        $categoriesWithActiveJobs = Category::whereHas('job_posts', function($query) {
            $query->where('status', 'active');
        })->count();

        // Get categories with jobs (for stats)
        $activeCategories = $categories->where('jobs_count', '>', 0)->count();
        
        return view('editor.categories.index', compact('categories', 'totalJobs', 'activeCategories', 'categoriesWithActiveJobs'));
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Category name is required',
            'name.unique' => 'A category with this name already exists',
            'name.max' => 'Category name cannot exceed 100 characters',
        ]);

        try {
            $category = Category::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'color' => $validated['color'] ?? '#10b981',
                'is_active' => $validated['is_active'] ?? true,
            ]);

            return redirect()->route('categories.index')
                ->with('success', 'Category "' . $category->name . '" created successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create category. Please try again.')
                ->withInput();
        }
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories')->ignore($category->id),
            ],
            'color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Category name is required',
            'name.unique' => 'A category with this name already exists',
            'name.max' => 'Category name cannot exceed 100 characters',
        ]);

        try {
            $oldName = $category->name;
            
            $category->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'color' => $validated['color'] ?? $category->color,
                'is_active' => $validated['is_active'] ?? $category->is_active,
            ]);

            $message = 'Category "' . $oldName . '" has been updated to "' . $category->name . '" successfully!';
            
            return redirect()->route('categories.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update category. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        // Check if category has any jobs
        $jobsCount = $category->jobs()->count();
        
        if ($jobsCount > 0) {
            return back()->with('error', 
                'Cannot delete "' . $category->name . '" because it has ' . $jobsCount . ' job(s) associated. 
                Please reassign or delete these jobs first.'
            );
        }

        try {
            $categoryName = $category->name;
            $category->delete();

            return back()->with('success', 'Category "' . $categoryName . '" has been deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete category. Please try again.');
        }
    }

    /**
     * Bulk delete categories
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $categories = Category::whereIn('id', $request->category_ids)->get();
        $deletedCount = 0;
        $failedCategories = [];

        foreach ($categories as $category) {
            if ($category->jobs()->count() === 0) {
                $category->delete();
                $deletedCount++;
            } else {
                $failedCategories[] = $category->name;
            }
        }

        if ($deletedCount > 0) {
            $message = $deletedCount . ' category(ies) deleted successfully.';
            if (count($failedCategories) > 0) {
                $message .= ' Could not delete: ' . implode(', ', $failedCategories) . ' (has jobs associated)';
            }
            return back()->with('success', $message);
        }

        return back()->with('error', 'No categories were deleted. Categories with jobs cannot be deleted.');
    }

    /**
     * Toggle category active status
     */
    public function toggleStatus(Category $category)
    {
        $category->update([
            'is_active' => !$category->is_active
        ]);

        $status = $category->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', 'Category "' . $category->name . '" has been ' . $status . ' successfully!');
    }

    /**
     * Get categories for API/JSON response
     */
    public function apiCategories()
    {
        $categories = Category::withCount([
            'jobs' => function($query) {
                $query->where('status', 'active');
            }
        ])
        ->where('is_active', true)
        ->orderBy('name')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Reorder categories (for drag-and-drop functionality)
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:categories,id',
        ]);

        foreach ($request->order as $index => $categoryId) {
            Category::where('id', $categoryId)->update(['order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Categories reordered successfully'
        ]);
    }
}