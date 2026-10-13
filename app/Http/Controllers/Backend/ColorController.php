<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Variation;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_color = ProductColor::orderBy('color', 'ASC')->get();
        return view('backend.pages.product-variation.color', compact('product_color'));
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
            'color_name' => 'required|string|max:255',
        ]);

        $color = new ProductColor();
        $color->color = trim($request->color_name);
        $color->save();

        $this->generateVariationsForColor($color->id);

        session()->flash('success', __('Color created successfully'));
        return back();
    }

    public function ajaxStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        $colorName = trim($request->color_name);

        // Check if color already exists (case-insensitive)
        $existing = ProductColor::whereRaw('LOWER(color) = ?', [strtolower($colorName)])->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => __('The color name has already been taken.'),
                'errors'  => [
                    'color_name' => [__('The color name has already been taken.')]
                ],
                'color'   => [
                    'id' => $existing->id,
                    'color_name' => $existing->color
                ]
            ], 422);
        }

        try {
            $color = new ProductColor();
            $color->color = $colorName;
            $color->save();

            // Fast bulk insert only for this color (~0.01s instead of 90s)
            $this->generateVariationsForColor($color->id);

            return response()->json([
                'success' => true,
                'message' => __('Color created successfully'),
                'color'   => [
                    'id' => $color->id,
                    'color_name' => $color->color
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
        $color = ProductColor::find($id);
        if ($color) {
            Variation::where('color_id', $color->id)->delete();
            $color->delete();
        }
        session()->flash('success', __('Color deleted successfully'));
        return back();
    }

    /**
     * Generate variations combinations for a single color (fast bulk insert)
     */
    public function generateVariationsForColor($colorId)
    {
        $sizes = ProductSize::pluck('id');
        $now = now();
        $records = [];
        foreach ($sizes as $sizeId) {
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
