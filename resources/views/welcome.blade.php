@extends('layouts.terrace.app')

@section('title', 'Belajar Online - Kursus Terbaik Indonesia')

@section('content')
    <!-- Hero -->
    <section class="bg-blue-50 py-20 text-center">
        <h2 class="text-4xl font-bold mb-4">Belajar Kapan Saja, Di Mana Saja</h2>
        <p class="text-lg mb-6 text-gray-600">Temukan ratusan kursus online berkualitas dari instruktur terbaik
            Indonesia.</p>
        <a href="/register" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Mulai Belajar
            Sekarang</a>
    </section>

    <!-- Fitur -->
    <section id="fitur" class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-10">Kenapa Memilih Kami?</h3>
            <div class="grid md:grid-cols-4 gap-6">
                <div>
                    <div class="text-blue-600 text-4xl mb-2">⏱️</div>
                    <h4 class="font-semibold mb-2">Fleksibel</h4>
                    <p>Belajar sesuai waktu luang kamu tanpa batasan.</p>
                </div>
                <div>
                    <div class="text-blue-600 text-4xl mb-2">📱</div>
                    <h4 class="font-semibold mb-2">Akses Mudah</h4>
                    <p>Gunakan laptop, HP, atau tablet tanpa hambatan.</p>
                </div>
                <div>
                    <div class="text-blue-600 text-4xl mb-2">👨‍🏫</div>
                    <h4 class="font-semibold mb-2">Instruktur Profesional</h4>
                    <p>Diajar oleh para ahli di bidangnya.</p>
                </div>
                <div>
                    <div class="text-blue-600 text-4xl mb-2">🏆</div>
                    <h4 class="font-semibold mb-2">Sertifikat</h4>
                    <p>Dapatkan sertifikat setelah menyelesaikan kursus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kursus Populer -->
    <section id="kursus" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-10">Kursus Populer</h3>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($courses as $course)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        @if ($course->cover_image)
                            <img src="{{ asset('storage/courses/' . $course->cover_image) }}" alt="{{ $course->name }}"
                                class="w-full h-58 object-cover">
                        @else
                            <img src="{{ asset('images/default-cover.jpg') }}" alt="Default Cover"
                                class="w-full h-58 object-cover">
                        @endif

                        <div class="p-6 text-left">
                            <h4 class="text-xl font-semibold mb-2">{{ $course->name }}</h4>
                            <p class="text-gray-600 line-clamp-3">{{ $course->description }}</p>
                            <p class="text-gray-800 font-bold mt-2">Rp {{ number_format($course->price, 0, ',', '.') }}
                            </p>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('terrace.courses.show', $course->slug) }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 ml-2">Lihat
                                    Detail</a>
                            </div>
                            {{-- <form action="{{ route('carts.store', $course) }}" method="POST"
                                class="inline-block">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 ml-2">Add to
                                    Cart</button>
                            </form> --}}
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="#" class="mt-8 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Lihat Semua Kursus
            </a>
        </div>
    </section>

    <!-- Tentang -->
    <section id="tentang" class="py-16 bg-white text-center">
        <div class="container mx-auto px-4">
            <h3 class="text-2xl font-bold mb-4">Tentang Kami</h3>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kami adalah platform pembelajaran online yang menyediakan kursus berkualitas untuk
                semua kalangan. Misi
                kami adalah memperluas akses pendidikan yang fleksibel dan terjangkau.
            </p>
        </div>
    </section>
@endsection
