<?php

namespace App\Http\Controllers\Admins;

use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Models\Product\Order;
use App\Models\Product\Booking;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminsController extends Controller
{
    public function viewLogin()
    {
        return view('admin.login');
    }

    public function checkLogin(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect()->route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function index()
    {
        $productsCount = Product::select()->count();
        $ordersCount = Order::select()->count();
        $bookingsCount = Booking::select()->count();
        $adminsCount = Admin::select()->count();

        return view('admin.index', compact('productsCount', 'ordersCount', 'bookingsCount', 'adminsCount'));
    }

    public function displayAllAdmins()
    {
        $allAdmins = Admin::select()->orderBy('id', 'desc')->get();
        return view('admin.all-admins', compact('allAdmins'));
    }

    public function createAdmins()
    {
        return view('admin.create-admins');
    }

    public function storeAdmins(Request $request)
    {
        Request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required', 
        ]);

        $storeAdmins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($storeAdmins){
            return Redirect::route('all.admins')->with('success', 'Admin Added Successfully');
        }
    }

    public function displayAllOrders()
    {
        $allOrders = Order::select()->orderBy('id', 'desc')->get();
        return view('admin.all-orders', compact('allOrders'));
    }

    public function editOrders($id)
    {
        $order = Order::find($id);
        return view('admin.edit-orders', compact('order'));
    }

    public function updateOrders(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update($request->all());

        if($order){
            return Redirect::route('all.orders')->with('update', 'Order Updated Successfully');
        }
    }

    public function deleteOrders($id)
    {
        $order = Order::find($id);
        $order->delete();
        if($order){
            return Redirect::route('all.orders')->with('delete', 'Order Deleted Successfully');
        }
    }
}
