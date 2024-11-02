@extends('welcome')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-10 mb-20">
    <div class="px-4 py-8 max-w-xl">
        <div class="bg-white shadow-2xl" >
            <div>
                <img src="{{ Storage::url($movie->upload_file) }}"  width="240" height="240">

            </div>
            <div class="px-4 py-2 mt-2 bg-white">
                <h2 class="font-bold text-2xl text-gray-800">{{ $movie->title }}</h2>
                <h6 class="font-bold text-1xl text-gray-700">{{ $movie->genre->name }}</h6>
                <p class="font-bold text-1xl text-gray-700">{{ $movie->released_date }}</p>
                <p class="sm:text-sm text-xs text-gray-700 px-2 mr-1 my-3">
                    {{ $movie->description }}
                </p>
            </div>
            <div class="px-4 py-2 mt-2 bg-white">

                <iframe width="500" height="250" src="{{ $movie->trailer_link }}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

</div>
@endsection
