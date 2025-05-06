<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        return $this->success(
            Product::all(),
            'Se han recuperado todos los productos',
        );
    }

    public function show(Product $product)
    {
        return $this->success(
            $product,
            'Se ha recuperado el producto'
        );
    }

    public function store(StoreRequest $request)
    {
        $product =  rescue(
            fn() => DB::transaction(
                fn() => Product::create($request->validated()
                )
            )
        );

        if (!$product){
            return $this->error(
                null,
                'Error al crear el producto'
            );
        }

        return $this->success(
            Product::all(),
            'Se ha creado un producto',
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $product =  rescue(
            fn() => DB::transaction(
                fn() => $product->update($request->validated()
                )
            )
        );

        if (!$product){
            return $this->error(
                null,
                'Error al actualizar el producto'
            );
        }

        return $this->success(
            Product::all(),
            'Se ha actualizado un producto'
        );
    }

    public function destroy(Product $product)
    {
        $delete = rescue(
            fn() => DB::transaction(
                fn() => $product->delete()
            )
        );

        if (!$delete){
            return $this->error(
                null,
                'Error al eliminar el producto'
            );
        }

        return $this->success(Product::all(),'Se ha eliminado el producto');
    }
}
