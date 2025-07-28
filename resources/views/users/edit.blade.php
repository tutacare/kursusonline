@extends('layouts.app')

@section('breadcrumbs')
    <span class="mx-2">></span>
    <a href="{{ route('users.index') }}" class="hover:underline">Users</a>
    <span class="mx-2">></span>
    <span>Edit</span>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit User</h1>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password (leave blank to keep
                        current):</label>
                    <input type="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" name="password">
                </div>

                <div class="mb-6">
                    <label for="roles" class="block text-gray-700 text-sm font-bold mb-2">Roles:</label>
                    <select
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="roles" name="roles[]" multiple>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->name, $userRoles) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:shadow-outline">
                        Update User
                    </button>
                    <a href="{{ route('users.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#jabatan').select2({
                placeholder: "-- Pilih Jabatan --"
            });
            $('#roles').select2();
        });
    </script>
@endpush
