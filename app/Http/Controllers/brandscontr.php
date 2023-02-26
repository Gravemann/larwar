<?php

namespace App\Http\Controllers;

use App\Http\Requests\brandsreq;
use App\Models\brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class brandscontr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(
                Brands::select('*')
                    ->where('brands.user_id', '=', Auth::id())->get()
            )
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'
                        . $row->id . '" data-original-title="Edit" class="edit btn btn-warning edit">
                Edit
            </a>
            <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete" data-id="'
                        . $row->id . '" class="delete btn btn-danger">
                Delete
            </a>';
                })
                ->editColumn('photo', function ($row) {
                    return '<img style="width:100px; height:auto" src="'
                        . ($row->photo) . '">';
                })
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y h:i:s', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'photo'])
                ->addIndexColumn()
                ->make(true);
        }

        return view(
            'brands',
            [
                'data' => brands::orderBy('id', 'desc')->where(
                    'user_id',
                    '=',
                    Auth::id()
                )->get()
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(brandsreq $request)
    {
        if ($request->id) {
            $con = Brands::find($request->id);
        } else {
            $con = new Brands;
        }

        $count = $con->where('name', '=', $request->name)->where(
            'user_id',
            '=',
            Auth::id()
        )->count();

        if ($count == 0) {
            if ($request->hasFile('p')) {
                $file = Str::random(6) . '.' . $request->p->extension();
                $request->p->storeAs('public/uploads/brands/', $file);
                $con->photo = 'storage/uploads/brands/' . $file;
            }

            $con->name = $request->name;

            $con->user_id = Auth::id();

            $con->save();

            return Response()->json($con);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(request $post)
    {
        $where = array('id' => $post->id);
        $brand = Brands::where($where)->first();

        return Response()->json($brand);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $get)
    {
        $brand = Brands::find($get->id)->delete();

        return Response()->json($brand);
    }
}
