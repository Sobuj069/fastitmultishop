<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\Variation;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_size = ProductSize::orderBy('id', 'DESC')->get();
        return view('backend.pages.product-variation.size', compact('product_size'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'size_name' => 'required|string|max:255',
        ]);

        $size = new ProductSize();
        $size->size = trim($request->size_name);
        $size->save();

        $this->generateVariationsForSize($size->id);

        session()->flash('success', __('Size created successfully'));
        return back();
    }

    public function ajaxStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        $sizeName = trim($request->size_name);

        // Check for existing size case-insensitively
        $existing = ProductSize::whereRaw('LOWER(size) = ?', [strtolower($sizeName)])->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => __('The size name has already been taken.'),
                'errors'  => [
                    'size_name' => [__('The size name has already been taken.')]
                ],
                'size'    => [
                    'id' => $existing->id,
                    'size_name' => $existing->size
                ]
            ], 422);
        }

        try {
            $size = new ProductSize();
            $size->size = $sizeName;
            $size->save();

            // Fast bulk insert only for this size (~0.01s instead of 90s)
            $this->generateVariationsForSize($size->id);

            return response()->json([
                'success' => true,
                'message' => __('Size created successfully'),
                'size'    => [
                    'id' => $size->id,
                    'size_name' => $size->size
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = ProductSize::find($id);
        if ($size) {
            Variation::where('size_id', $size->id)->delete();
            $size->delete();
        }
        session()->flash('success', __('Size deleted successfully'));
        return back();
    }

    /**
     * Generate variations combinations for a single size (fast bulk insert)
     */
    public function generateVariationsForSize($sizeId)
    {
        $colors = ProductColor::pluck('id');
        $now = now();
        $records = [];
        foreach ($colors as $colorId) {
            $records[] = [
                'size_id' => $sizeId,
                'color_id' => $colorId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (!empty($records)) {
            foreach (array_chunk($records, 1000) as $chunk) {
                Variation::insert($chunk);
            }
        }
    }

    /**
     * Generate all variation combinations using chunked bulk inserts
     */
    public function generateVariations()
    {
        $sizes = ProductSize::pluck('id');
        $colors = ProductColor::pluck('id');

        Variation::truncate();

        $now = now();
        $records = [];
        foreach ($sizes as $sizeId) {
            foreach ($colors as $colorId) {
                $records[] = [
                    'size_id' => $sizeId,
                    'color_id' => $colorId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                if (count($records) >= 1000) {
                    Variation::insert($records);
                    $records = [];
                }
            }
        }

        if (!empty($records)) {
            Variation::insert($records);
        }

        return response()->json(['message' => 'Variations generated successfully.']);
    }
}
