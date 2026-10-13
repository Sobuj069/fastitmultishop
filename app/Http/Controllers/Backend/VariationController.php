<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\Variation;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variations = Variation::orderBy('id','DESC')->get();
        return view('backend.pages.product-variation.variation',compact('variations'));
    }

    public function generateVariations()
    {
        // Fetch all sizes and colors
        $sizes = ProductSize::pluck('id');
        $colors = ProductColor::pluck('id');

        // Clear existing variations
        Variation::truncate();

        // Generate combinations using bulk insert
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

    public function getVariations()
    {
        $variations = Variation::with('size', 'color')->get();
        return response()->json($variations);
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
        //
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
        //
    }
}
