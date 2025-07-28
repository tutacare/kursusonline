<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $carts = Auth::user()->carts()->with('course')->get();
        } else {
            $cartCourseIds = session()->get('cart', []);
            $carts = Course::whereIn('id', $cartCourseIds)->get()->map(function ($course) {
                // Create a dummy Cart object for consistency in view
                $cart = new Cart();
                $cart->course = $course;
                $cart->id = $course->id; // Use course ID as dummy cart ID for session items
                return $cart;
            });
        }
        return view('carts.index', compact('carts'));
    }

    public function store(Request $request, Course $course)
    {
        if (Auth::check()) {
            Cart::firstOrCreate([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
            ]);
        } else {
            $cart = session()->get('cart', []);
            if (!in_array($course->id, $cart)) {
                $cart[] = $course->id;
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('terrace.carts.index')->with('success', 'Course added to cart.');
    }

    public function destroy(Request $request, $identifier)
    {
        if (Auth::check()) {
            // User is logged in, try to find by encrypted_id
            $cart = Cart::where('encrypted_id', $identifier)->firstOrFail();
            $this->authorize('delete', $cart);
            $cart->delete();
        } else {
            // User is a guest, remove from session using course_id
            $cart = session()->get('cart', []);
            if (($key = array_search($identifier, $cart)) !== false) {
                unset($cart[$key]);
                session()->put('cart', array_values($cart)); // Re-index array
            }
        }
        return redirect()->route('terrace.carts.index')->with('success', 'Course removed from cart.');
    }
}
