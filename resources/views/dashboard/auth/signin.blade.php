@extends('welcome')

@section('content')

<div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
    <div class="bg-white w-96 shadow-xl rounded p-5">
        <h1 class="text-3xl font-medium">Login Page</h1>

        <form method="POST" action="{{ route('auth.sign-in') }}" class="space-y-5 mt-5">
            @csrf
            <input name="username" type="text" class="w-full h-12 border rounded px-3" value="{{ old('username') }}" placeholder="username" />

            @error('username')
                <p class="text-red-500">{{ $message }}</p>
            @enderror

            <input name="password" type="password" class="w-full h-12 border border-gray-800 rounded px-3" placeholder="Пароль" />

            @error('password')
                <p class="text-red-500">{{ $message }}</p>
            @enderror

            <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">login</button>
        </form>
    </div>
</div>
@endsection
