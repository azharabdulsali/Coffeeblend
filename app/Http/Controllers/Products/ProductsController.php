<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Cart;
use App\Models\Product\Order;
use App\Models\Product\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function singleProduct($id)
    {

        $product = Product::find($id);

        $relatedProducts = Product::where('type', $product->type)
            ->where('id', '!=', $id)->take(4)
            ->orderBy('id', 'desc')
            ->get();

        // check if product is in cart

        $checkingInCart = Cart::where('pro_id', $id)
            ->where('user_id', Auth::user()->id)
            ->count();

        return view('products.productsingle', compact('product', 'relatedProducts', 'checkingInCart'));
    }

    public function addCart(Request $request, $id)
    {
        $addCart = Cart::create([
            'pro_id' => $request->pro_id,
            'name' => $request->name,
            'price' => $request->price,
            'image' => $request->image,
            "user_id" => Auth::user()->id,
        ]);

        return Redirect::route('product.single', $id)->with('success', 'Product Added To Cart');
    }

    public function cart()
    {
        $cartProducts = Cart::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();

        $totalPrice = Cart::where('user_id', Auth::user()->id)
            ->sum('price');

        return view('products.cart', compact('cartProducts', 'totalPrice'));
    }

    public function deleteProductCart($id)
    {
        $deleteProductCart = Cart::where('pro_id', $id)
            ->where('user_id', Auth::user()->id);

        $deleteProductCart->delete();

        if ($deleteProductCart) {
            return Redirect::route('cart')->with('delete', 'Product Removed From Cart');
        }
    }

    public function prepareCheckout(Request $request)
    {
        $value = $request->price;

        $price = Session::put('price', $value);

        $newPrice = Session::get('price');

        if ($newPrice > 0) {

            return Redirect::route('checkout');
        }
    }

    public function checkout()
    {
        return view('products.checkout');
    }

    public function storeCheckout(Request $request)
    {
        $checkout = Order::create($request->all());

        if ($checkout) {
            return Redirect::route('products.pay');
        }
    }

    public function payWithPaypal()
    {
        return view('products.pay');
    }

    public function success()
    {
        $deleteItems = Cart::where('user_id', Auth::user()->id)
            ->delete();

        if ($deleteItems) {

            Session::forget('price');
            return view('products.success');
        }
    }

    public function bookTables(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        if ($request->date > date('n/j/Y')) {
            $bookTables = Booking::create($request->all());

            if ($bookTables) {
                return Redirect::route('home')->with('booking', 'Table Booked Successfully');
            }
        } else {
            return Redirect::route('home')->with('date', 'Invalid Date, Choose Another Date In The Future');
        }
    }

    public function menu(){

        $desserts = Product::select()->where('type', 'dessert')->orderBy('id', 'desc')->take(4)->get();
        $drinks = Product::select()->where('type', 'drinks')->orderBy('id', 'desc')->take(4)->get();

        return view('products.menu', compact('desserts', 'drinks'));
    }
}
