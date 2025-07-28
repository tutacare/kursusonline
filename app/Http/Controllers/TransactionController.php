<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();

        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melakukan checkout.');
        }

        if (!$user->hasRole('student')) {
            return redirect()->back()->with('error', 'Anda harus login sebagai student untuk melakukan checkout.');
        }

        $cartItems = Cart::where('user_id', $user->id)->with('course')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->course->price;
        });

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'paid',
            ]);

            foreach ($cartItems as $cartItem) {
                $user->courses()->attach($cartItem->course_id);
                $cartItem->delete(); // Hapus item dari keranjang setelah transaksi
            }

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Kursus Anda telah ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
}
