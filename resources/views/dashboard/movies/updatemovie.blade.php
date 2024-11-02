@extends('welcome')

@section('content')
<div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
    <<div class="bg-white w-96 shadow-xl rounded p-5">
        <h1 class="text-3xl font-medium">Add movies</h1>

        <form method="POST" action="{{ route('dashboard.movies.update-movie', $movie->id) }}" class="space-y-5 mt-5" enctype="multipart/form-data">
            @csrf
            <select name="genre_id">
                <option selected value="{{ $movie->genre->id }}">{{ $movie->genre->name }}</option>
                @foreach ($genres as $genre)
                    @if ($movie->genre->id !== $genre->id)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endif
                @endforeach
              </select>
            <input name="title" type="text" class="w-full h-12 border border-gray-800 rounded px-3" placeholder="title" value="{{ $movie->title }}" />
            <input name="released_date" type="date" class="w-full h-9 border border-gray-800 rounded px-3" value="{{ $movie->released_date }}" placeholder="released data" />
            <textarea name="description" class="w-full h-12 border border-gray-800 rounded px-3" placeholder="description">{{ $movie->description }}</textarea>
            <input name="trailer_link" type="text" class="w-full h-9 border border-gray-800 rounded px-3" value="{{ $movie->trailer_link }}" placeholder="trailer link" />
            @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded">
                    <ul>
                      @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <img src="{{ Storage::url($movie->upload_file) }}" alt="{{ $movie->title }}" width="150" height="150">
            <input name="file" type="file" value="{{ $movie->upload_file }}" />

            <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Add</button>
        </form>
    </div>
</div>
@endsection
