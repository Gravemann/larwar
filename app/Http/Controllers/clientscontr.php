<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\clientsreq;

use Illuminate\Support\Facades\Auth;

use App\Models\clients;
use Illuminate\Auth\Access\Response;

class clientscontr extends Controller
{
    public function add(clientsreq $post)
    {

        $con = new clients();

        $count = $con->where('tel', '=', $post->c)->where('user_id', '=', Auth::id())->count();

        if ($count == 0) {
            $post->validate([
                'p' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1500,max_height=1000',
            ]);

            if ($post->file('p')) {
                $file = time() . '.' . $post->p->extension();
                $post->p->storeAs('public/uploads/clients/', $file);
                $con->photo = 'storage/uploads/clients/' . $file;
            }
            $con->name = $post->a;
            $con->surname = $post->b;
            $con->tel = $post->c;
            $con->company = $post->d;
            $con->user_id = Auth::id();

            $con->save();

            return redirect()->route('clients')->with('success', 'The client was added successfully');
        }

        return redirect()->route('clients')->with('success', 'This client is already on the base');
    }

    public function list()
    {

        return view('clients', ['data' => clients::orderBy('id', 'desc')->where('user_id', '=', Auth::id())->get()]);
    }



    public function edit($id)
    {
        return HandleInertiaRequests
        $this->authorizeResource()
        return view('clients', [
            'data' => clients::orderBy('id', 'desc')->where('user_id', '=', Auth::id())->get(),
            'editdata' => clients::find($id)
        ]);
    }



    public function update(clientsreq $post)
    {


        $con = new clients();

        $update = clients::find($post->id);

        $post->validate([
            'p' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=50,min_height=50,max_width=1500,max_height=1000',
        ]);

        if ($post->file('p')) {
            $file = time() . '.' . $post->p->extension();
            $post->p->storeAs('public/uploads/clients/', $file);
            $update->photo = 'storage/uploads/clients/' . $file;
        }
        $update->name = $post->a;
        $update->surname = $post->b;
        $update->tel = $post->c;
        $update->company = $post->d;

        $update->save();

        return redirect()->route('clients')->with('success', 'The client was updated successfully');
    }


    public function qdelete($id)
    {

        return view('clients', [
            'data' => clients::orderBy('id', 'desc')->where('user_id', '=', Auth::id())->get(),
            'deletedata' => clients::find($id)
        ]);
    }

    public function condel($id)
    {

        clients::find($id)->delete();
        return redirect()->route('clients')->with('success', 'The client was deleted successfully');
    }
}
