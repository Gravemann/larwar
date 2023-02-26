<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\productsreq;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;

use App\Models\products;

use App\Models\brands;

class productscontr extends Controller


{
    public function add(productsreq $post)
    {

        $con = new products();

        $count = $con->where('brand_id', '=', $post->brand_id)->where('name', '=', $post->a)->count();

        if ($count == 0) {

            $post->validate([
                'p' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ]);

            if ($post->file('p')) {
                $file = time() . '.' . $post->p->extension();
                $post->p->storeAs('public/uploads/products/', $file);
                $con->photo = 'storage/uploads/products/' . $file;
            }
            $con->brand_id = $post->brand_id;
            $con->name = $post->a;
            $con->buy = $post->b;
            $con->sale = $post->c;
            $con->quantity = $post->d;
            $con->user_id = Auth::id();

            $con->save();

            return redirect()->route('products')->with('success', 'The product was added successfully');
        }

        return redirect()->route('products')->with('success', 'This product is already on the base');
    }

    public function list()
    {

        return view('products', [
            'data' => products::join('brands', 'brands.id', '=', 'products.brand_id')
                ->select('products.id', 'products.name AS product', 'products.buy', 'products.sale', 'products.quantity', 'products.photo AS photo', 'brands.name AS brand')
                ->orderBy('id', 'desc')->where('products.user_id', '=', Auth::id())->get(),
            'brdata' => brands::orderBy('name', 'asc')->where('user_id', '=', Auth::id())->get()
        ]);
    }



    public function edit($id)
    {

        return view('products', [
            'data' => brands::orderbyDesc('id')->with('products')->where('user_id', '=', Auth::id())->get(),
            'brdata' => brands::orderBy('name', 'asc')->get(),
            'editdata' => products::find($id)
        ]);
    }



    public function update(productsreq $post)
    {

        $con = new products();

        $update = products::find($post->id);

        $post->validate([
            'p' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ]);

        if ($post->file('p')) {
            $file = time() . '.' . $post->p->extension();
            $post->p->storeAs('public/uploads/products/', $file);
            $update->photo = 'storage/uploads/products/' . $file;
        }

        $update->brand_id = $post->brand_id;
        $update->name = $post->a;
        $update->buy = $post->b;
        $update->sale = $post->c;
        $update->quantity = $post->d;

        $update->save();

        return redirect()->route('products')->with('success', 'The product was updated successfully');
    }


    public function qdelete($id)
    {

        return view('products', [
            'data' => brands::orderbyDesc('id')->with('products')->where('user_id', '=', Auth::id())->get(),
            'brdata' => brands::orderBy('name', 'asc')->get(),
            'deletedata' => products::find($id)
        ]);
    }

    public function condel($id)
    {

        products::find($id)->delete();
        return redirect()->route('products')->with('success', 'The product was deleted successfully');
    }
}
