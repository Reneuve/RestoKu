<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    //
    public function create(Request $request)
    {
        # code...
        $this->validate($request, [
            'name' => 'required|max:40|unique:menus,name',
            'price' => 'required|numeric|min:500|max:1000000',
            'description' => 'required|min:5',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $img = $request->file('image');
        $imgName = time() . $img->getClientOriginalName();
        $img->move(public_path('asset/menus'), $imgName);
        DB::table('menus')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imgName,
        ]);
        return redirect()->back()->with('success', 'Menu ' . $request->name . ' telah berhasil ditambah');
    }
    public function view()
    {
        # code...
        $data = DB::table('menus')->paginate(12);
        return view('admins.menu.view', ['menus' => $data]);
    }

    public function updateView(Request $request)
    {
        # code...
        $data = DB::table('menus')->where('id', $request->id)->get();
        return view('admins.menu.edit', ['menus' => $data]);
    }

    public function update(Request $request)
    {
        # code...
        $this->validate($request, [
            'name' => 'required|max:40|unique:menus,name,' . $request->id,
            'price' => 'required|numeric|min:500|max:1000000',
            'description' => 'required|min:5',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($request->has('image')) {
            # code jika gambar diganti
            $img = $request->file('image');
            $imgName = time() . $img->getClientOriginalName();
            $img->move(public_path('asset/menus'), $imgName);
            DB::table('menus')->where('id', $request->id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $imgName,
            ]);
        } else {
            DB::table('menus')->where('id', $request->id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
            ]);
        }
        return redirect()->back()->with('success', "Menu telah berhasil diperbarui");
    }
    public function delete(Request $request)
    {
        # code...
        DB::table('menus')->delete($request->id);
        return redirect()->back();
    }

    public function activeMenu(Request $request)
    {
        # code...
        DB::table('menus')->where('id', $request->id)->update([
            'is_active' => 1,
        ]);
        return redirect()->back();
    }

    public function nonActiveMenu(Request $request)
    {
        # code...
        DB::table('menus')->where('id', $request->id)->update([
            'is_active' => 0,
        ]);
        return redirect()->back();
    }
}
