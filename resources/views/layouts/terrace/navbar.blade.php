<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">KursusOnline</h1>
        <nav class="space-x-6">
            <a href="{{ route('courses.index') }}" class="text-gray-600 hover:text-blue-600">Kursus</a>
            <a href="#fitur" class="text-gray-600 hover:text-blue-600">Fitur</a>
            <a href="#tentang" class="text-gray-600 hover:text-blue-600">Tentang</a>
            <a href="#kontak" class="text-gray-600 hover:text-blue-600">Kontak</a>
            <a href="{{ route('terrace.carts.index') }}" class="relative text-gray-600 hover:text-blue-600">
                <i class="fas fa-shopping-cart text-xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    {{ Auth::check() ? auth()->user()->carts()->count() : count(session()->get('cart', [])) }}
                </span>
            </a>

        </nav>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline mr-4">Masuk</a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Daftar</a>
            @endauth
        </div>
    </div>
</header>
