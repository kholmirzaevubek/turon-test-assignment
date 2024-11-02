@extends('welcome')
@section('content')

<form method="GET" action="{{ route('home.') }}">
    <div class="flex items-center space-x-4 mb-4">
        <select name="genre_id" class="border border-gray-300 rounded-md p-2">
            <option value="">Select Genre</option>
            @foreach ($genres as $genre)
            <option value={{$genre->id}}>{{ $genre->name }}</option>
            @endforeach
        </select>

        <input type="text" name="title" placeholder="Search by Title"
        class="border border-gray-300 rounded-md p-2 w-1000" />

        <button type="submit" class="text-center bg-blue-900 rounded-md text-white py-3 font-medium">search</button>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-10 mb-20">
@foreach ($movies as $movie)

    <div class="px-4 py-8 max-w-xl">
        <div class="bg-white shadow-2xl" >
            <div>
                <a href="{{ route('home.get-specific-movie', $movie->id) }}">
                    <img src="{{ Storage::url($movie->upload_file) }}"  width="240" height="240">
                </a>
            </div>
            <div class="px-4 py-2 mt-2 bg-white">
                <h2 class="font-bold text-2xl text-gray-800">{{ $movie->title }}</h2>
                <p class="sm:text-sm text-xs text-gray-700 px-2 mr-1 my-3">
                    {{ $movie->description }}
                </p>
            </div>
        </div>
    </div>

    @endforeach
    <div>
        {{$movies->links('pagination::tailwind')}}

    </div>
</div>
@endsection
