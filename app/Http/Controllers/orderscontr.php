<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use App\Models\orders;

use App\Models\brands;

use App\Models\products;

use App\Models\clients;

use DB;

class orderscontr extends Controller
{
    public function list()
    {

        if (request()->ajax()) {
            return datatables()->of(Orders::join('clients', 'clients.id', '=', 'orders.client_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->select(
                    'orders.id',
                    'orders.quantity',
                    'orders.confirm',
                    'orders.created_at',
                    'brands.name AS brname',
                    DB::raw("CONCAT(clients.name,' ',clients.surname) as fullname"),
                    'products.name AS product',
                    'products.buy',
                    DB::raw("((products.sale - products.buy) * orders.quantity) as profit"),
                    'products.sale',
                    'products.quantity AS stock'
                )
                ->where('orders.user_id', '=', Auth::id())->get())
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y h:i:s', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    if ($row->confirm == 0) {
                        return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning edit">
                    Edit
                </a>
                <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete" data-id="' . $row->id . '" class="delete btn btn-danger">
                    Delete
                </a>
                <a href="javascript:void(0);" id="confirm" data-toggle="tooltip" data-original-title="Confirm" data-id="' . $row->id . '" class="confirm btn btn-success">
                    Confirm
                </a>';
                    } else {
                        return '<a href="javascript:void(0);" id="unconfirm" data-toggle="tooltip" data-original-title="Unconfirm" data-id="' . $row->id . '"
                class="unconfirm btn btn-info">
                    Unconfirm
                </a>';
                    }
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('orders', [
            'data' => orders::join('clients', 'clients.id', '=', 'orders.client_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->select(
                    'orders.id',
                    'orders.quantity',
                    'orders.confirm',
                    'orders.client_id',
                    'orders.product_id',
                    'brands.name AS brname',
                    DB::raw("CONCAT(clients.name,' ',clients.surname) as fullname"),
                    'products.name AS product',
                    'products.buy',
                    'products.sale',
                    'products.quantity AS stock'
                )
                ->orderBy('id', 'desc')->where('orders.user_id', '=', Auth::id())->get(),
            'brdata' => brands::orderBy('id', 'desc')->where('user_id', '=', Auth::id())->get(),
            'cldata' => clients::orderBy('id', 'desc')->where('user_id', '=', Auth::id())->get(),
            'prdata' => products::join('brands', 'brands.id', '=', 'products.brand_id')
                ->select('brands.name AS brname', 'products.brand_id', 'products.id', 'products.name', 'products.quantity', 'products.buy', 'products.sale')
                ->where('products.user_id', '=', Auth::id())
                ->get(),
            'buysum' => products::where('user_id', '=', Auth::id())->sum('buy'),
            'salesum' => products::where('products.user_id', '=', Auth::id())->sum('sale'),
            'qsum' => orders::where('orders.user_id', '=', Auth::id())->sum('quantity'),
            'profit' => products::join('orders', 'orders.product_id', '=', 'products.id')
                ->where('orders.user_id', '=', Auth::id())
                ->selectraw('sum((products.sale - products.buy) * orders.quantity) AS profit')
                ->get(),
            'cprofit' => products::join('orders', 'orders.product_id', '=', 'products.id')
                ->selectraw('sum((products.sale - products.buy) * orders.quantity) AS cprofit')
                ->where('orders.user_id', '=', Auth::id())->where('orders.confirm', '=', '1')
                ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $post)
    {

        $orderId = $post->id;

        if ($orderId) {
            $con = Orders::find($orderId);
        } else {
            $con = new Orders;
        }

        $con->client_id = $post->client_id;

        $con->product_id = $post->product_id;

        $con->quantity = $post->q;

        $con->confirm = 0;

        $con->user_id = Auth::id();

        $con->save();

        return Response()->json($con);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(request $post)
    {
        $where = array('id' => $post->id);
        $order  = Orders::where($where)->first();

        return Response()->json($order);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $post)
    {
        $where = array('id' => $post->id);
        $order = Orders::where($where)->delete();

        return Response()->json($order);
    }


    /**
     * Confirm the specified resourse.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function confirm(request $post)
    {

        $orderId = $post->id;

        $conor = orders::find($orderId);

        $conpr = products::find($conor->product_id);

        $qor = $conor->quantity;
        $qpr = $conpr->quantity;

        $result = $qpr - $qor;
        $conpr->quantity = $result;
        $conpr->save();

        $conor->confirm = 1;
        $conor->save();

        return Response()->json($conpr);
        return Response()->json($conor);
    }


    /**
     * Unconfirm the specified resourse.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function unconfirm(request $post)
    {

        $orderId = $post->id;

        $conor = orders::find($orderId);

        $conpr = products::find($conor->product_id);

        $qor = $conor->quantity;
        $qpr = $conpr->quantity;


        $result = $qpr + $qor;
        $conpr->quantity = $result;
        $conpr->save();

        $conor->confirm = 0;
        $conor->save();

        return Response()->json($conpr);
        return Response()->json($conor);
    }
}
