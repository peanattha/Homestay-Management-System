<?php

namespace App\Http\Controllers;

use App\Models\set_menu;
use Illuminate\Http\Request;
use App\Models\user;

class MenuController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function manage_menu(){
        $set_menus = set_menu::all();
        return view('admin.manage-menu',compact('set_menus'));
    }
    public function add_menu(Request $request){
        $add_set_menu = new set_menu;
        $add_set_menu->set_menu_name =  $request->set_menu_name;
        $add_set_menu->status =  $request->status;
        $add_set_menu->price =  $request->price;
        $add_set_menu->detail = $request->details;

        $this->validate($request, [
            'menu_img' => 'required',
            'menu_img.*' => 'mimes:jpg,jpeg,png', 'max:10240'
        ]);

        foreach ($request->file('menu_img') as $img) {
            $name = $img->getClientOriginalName();
            $img->move(public_path() . '/storage/images/', $name);
            $data[] = $name;
        }

        $add_set_menu->menu_img = json_encode($data);
        $add_set_menu->save();
        return redirect()->back();
    }
    public function delete_menu($id)
    {
        set_menu::find($id)->delete();
        return redirect()->back();
    }
    public function menu_details($id){
        $set_menu = set_menu::find($id);
        return view('admin.menu-detail',compact('set_menu'));
    }
    public function delete_img($id, $menu_img)
    {
        $update_set_menu = set_menu::find($id);
        $set_menu = set_menu::find($id);
        foreach (json_decode($set_menu->menu_img) as $img) {
            if ($img == $menu_img) {
                $path = public_path() . '/storage/images/' . $img;
                unlink($path);
            } else {
                $data[] = $img;
            }
        }
        $update_set_menu->menu_img = json_encode($data);
        $update_set_menu->save();
        return redirect()->back();
    }
    public function edit_menu(Request $request, $id)
    {
        $update_set_menu = set_menu::find($id);
        $update_set_menu->set_menu_name =  $request->set_menu_name;
        $update_set_menu->status =  $request->status;
        $update_set_menu->price =  $request->price;
        $update_set_menu->detail = $request->details;

        if ($request->hasfile('menu_img')) {
            $this->validate($request, [
                'menu_img' => 'required',
                'menu_img.*' => 'mimes:jpg,jpeg,png', 'max:10240'
            ]);

            $set_menu = set_menu::find($id);

            foreach (json_decode($set_menu->menu_img) as $imgIn) {
                $data[] = $imgIn;
            }

            foreach ($request->file('menu_img') as $img) {
                $duplicate = 0;
                foreach (json_decode($set_menu->menu_img) as $imgIn) {
                    $name = $img->getClientOriginalName();
                    if ($imgIn == $name) {
                        $duplicate += 1;
                    }
                }
                if ($duplicate == 0) {
                    $img->move(public_path() . '/storage/images/', $name);
                    $data[] = $name;
                }
            }
            $update_set_menu->menu_img = json_encode($data);
        }

        $update_set_menu->save();
        return redirect()->back();
    }
    public function search_set_menu(Request $request){
        if (isset($request->set_menu_name)) {
            $set_menus = set_menu::where('set_menu_name', $request->set_menu_name)->get();
            if (($set_menus->count() == 0)) {
                return redirect()->route('manage-menu')->with('error', 'ไม่มีรายการค้นหา');;
            }
        } else {
            $set_menus = set_menu::all();
        }
        return view('admin.manage-menu', compact('set_menus'));
    }
}
