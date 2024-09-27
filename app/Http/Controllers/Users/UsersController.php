<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use App\Models\Product\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    public function displayOrders()
    {
        $orders = Order::select()->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('users.orders', compact('orders'));
    }

    public function displayBookings()
    {
        $bookings = Booking::select()->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('users.bookings', compact('bookings'));
    }

    public function writeReview()
    {
        return view('users.write-review');
    }

    public function processWriteReview(Request $request)
    {
        $writeReview = Review::create([
            'name' => Auth::user()->name,
            'review' => $request->review
        ]);

        // dd($writeReview);

        if ($writeReview) {
            return Redirect::route('write.reviews')->with('review', 'Review Added Successfully');
        }
    }
}
