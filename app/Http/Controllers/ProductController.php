<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $products = Product::latest()->paginate(5);
        return Inertia::render('AdminPages/Products/Index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('AdminPages/Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);
        if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        } else {
            $extension = 'png';
        }

        $fileName = Str::random() . '.' . $extension;

        $path = public_path() . '/' . $fileName;

        file_put_contents($path, $decoded);

        $product = Product::create($request->except('image') + [
                'image' => $fileName
            ]);

        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        return Inertia::render('AdminPages/Products/Show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        return Inertia::render('AdminPages/Products/Edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $string = $request->image;

        if ($string == $product->image) {
            $product->update($request->all());
            return response()->json([], 200);
        } else {
            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png';
            }

            $fileName = Str::random() . '.' . $extension;

            $path = public_path() . '/' . $fileName;

            file_put_contents($path, $decoded);

            $product->update($request->except('image') + [
                    'image' => $fileName
                ]);

            return response()->json([], 200);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $product->delete();

    }
}
