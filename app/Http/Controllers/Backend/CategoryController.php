<?php

namespace App\Http\Controllers\Backend;

use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\BranchCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $userBranchId = auth()->user()->branch_id;
        $filterBranchId = session('branch_filter_id', auth()->user()->branch_id);

        if ($userBranchId == 1) {
            if ($filterBranchId) {
                $categoryIds = BranchCategory::where('branch_id', $filterBranchId)->pluck('category_id');
                $categories = Category::whereIn('id', $categoryIds)->orderBy('id', 'desc')->paginate(20);
            } else {
                $categories = Category::orderBy('id', 'desc')->paginate(20);
            }
        } else {
            $categoryIds = BranchCategory::where('branch_id', $userBranchId)->pluck('category_id');
            $categories = Category::whereIn('id', $categoryIds)->orderBy('id', 'desc')->paginate(20);
        }
        $categoryIds = BranchCategory::where('branch_id', $userBranchId)->pluck('category_id');

        $branchs = Branch::all();
        return view('backend.pages.category.index',  compact('categories', 'branchs', 'filterBranchId','categoryIds'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'branch_id' => auth()->user()->branch_id == 1 ? 'required|array' : 'nullable',
        ]);

        $category = new Category();
        $category->name = $request->name;

        DB::transaction(function () use ($request, $category) {
            if ($category->save()) {
                if(auth()->user()->branch_id == 1){
                    foreach ($request->branch_id as $key => $branch_id) {
                        $branch_category = new BranchCategory();
                        $branch_category->category_id = $category->id;
                        $branch_category->branch_id = $branch_id;
                        $branch_category->save();
                    }
                }else{
                    $branch_category = new BranchCategory();
                    $branch_category->category_id = $category->id;
                    $branch_category->branch_id = auth()->user()->branch_id;
                    $branch_category->save();
                }
            }
        });

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Category created successfully'),
                'category' => $category,
            ]);
        }

        session()->flash('success', __('Category created successfully'));
        return back();
    }

    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        DB::transaction(function () use ($request, $category) {
            if ($category->save()) {
                if($request->branch_id != null){
                $existingBranchIds = BranchCategory::where('category_id', $category->id)
                    ->pluck('branch_id')
                    ->toArray();
        
                foreach ($request->branch_id as $branch_id) {
                    if (!in_array($branch_id, $existingBranchIds)) {
                        BranchCategory::create([
                            'category_id' => $category->id,
                            'branch_id' => $branch_id,
                        ]);
                    }
                }
                BranchCategory::where('category_id', $category->id)
                    ->whereNotIn('branch_id', $request->branch_id)
                    ->delete();
                }
            }
        });

        session()->flash('success', __('Category updated successfully'));
        return back();
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        session()->flash('success', __('Category deleted successfully'));
        return back();
    }
}
