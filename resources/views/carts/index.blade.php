@extends('layouts.terrace.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Keranjang Belanja Anda</h2>

            @if ($carts->isEmpty())
                <p class="text-center text-gray-600">Keranjang Anda kosong. Ayo, temukan kursus menarik!</p>
                <div class="text-center mt-6">
                    <a href="{{ route('courses.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        Lihat Semua Kursus
                    </a>
                </div>
            @else
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kursus</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($carts as $cart)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($cart->course->cover_image)
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/courses/' . $cart->course->cover_image) }}" alt="{{ $cart->course->name }}">
                                                @else
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('images/default-cover.jpg') }}" alt="Default Cover">
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $cart->course->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Rp {{ number_format($cart->course->price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('carts.destroy', Auth::check() ? $cart->encrypted_id : $cart->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 text-right">
                    <p class="text-xl font-bold">Total: Rp {{ number_format($carts->sum(function($cart) { return $cart->course->price; }), 0, ',', '.') }}</p>
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">Lanjutkan ke Pembayaran</button>
                    </form>
                </div>
            @endif
        </div>
    </section>
@endsection