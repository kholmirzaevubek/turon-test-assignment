@extends('welcome')

@section('content')
<div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
    <<div class="bg-white w-96 shadow-xl rounded p-5">
        <h1 class="text-3xl font-medium">Add movies</h1>

        <form method="POST" action="{{ route('dashboard.genres.create-genre') }}" class="space-y-5 mt-5" enctype="multipart/form-data">
            @csrf
            <input name="name" type="text" class="w-full h-9 border border-gray-800 rounded px-3" placeholder="genre name" />
            @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded">
                    <ul>
                      @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Add</button>
        </form>
    </div>
</div>
@endsection
