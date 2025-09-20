<?php

namespace App\Http\Controllers;

use App\Models\MobileBooking;
use Illuminate\Http\Request;

class MobileBookingController extends Controller
{
    public function index()
    {
        $bookings = MobileBooking::latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('admin.bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'deposit' => 'required|numeric|min:0',
            'booking_date' => 'required|date',
        ]);

        MobileBooking::create($request->all());

        return redirect()->route('bookings.index')->with('success', 'تم إنشاء الحجز بنجاح.');
    }

    public function edit(MobileBooking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, MobileBooking $booking)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'deposit' => 'required|numeric|min:0',
            'booking_date' => 'required|date',
        ]);

        $booking->update($request->all());

        return redirect()->route('bookings.index')->with('success', 'تم تحديث الحجز بنجاح.');
    }

    public function destroy(MobileBooking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'تم حذف الحجز بنجاح.');
    }
}
