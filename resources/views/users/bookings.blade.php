@extends('layouts.app')

@section('content')
    <section class="home-slider owl-carousel">

        <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">

                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">My Bookings</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>My
                                Bookings</span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table-dark" style="width: 1100px">
                            <thead style="background-color: #c49b63"; height="60px">
                                <tr class="text-center">
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bookings->count() > 0)
                                    @foreach ($bookings as $booking)
                                        <tr class="text-center" style="height: 140px">
                                            <td class="product-remove">{{ $booking->first_name }}</td>
                                            </td>

                                            <td class="">{{ $booking->last_name }}</td>
                                            </td>

                                            <td class="">{{ $booking->date }}</td>

                                            <td>
                                                {{ $booking->time }}
                                            </td>

                                            <td class="">{{ $booking->phone }}</td>
                                            <td class="">{{ $booking->status }}</td>
                                            <td>
                                                @if ($booking->status == 'Booked')
                                                    <a class="btn btn-primary" href="#">Write Review</a>
                                                @else
                                                    <p>Not Available</p>
                                                @endif
                                            </td>
                                        </tr><!-- END TR-->
                                    @endforeach
                                @else
                                    <p class="alert alert-danger">You Have No Bookings</p>">
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table> --}}
@endsection
