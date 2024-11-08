@extends('welcome')

@section('content')
<div>

            <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
                <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

                <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
                    <div class="flex items-center justify-center mt-8">
                        <div class="flex items-center">
                            <svg class="h-12 w-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                            </svg>
                        </div>
                    </div>

                    <nav class="mt-10">
                        <a class="flex items-center mt-4 py-2 px-6 bg-gray-700 bg-opacity-25 text-gray-100" href="{{ route('dashboard.movies.list-movies') }}">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>

                            <span class="mx-3">Movies</span>
                        </a>
                    </nav>
                </div>

                <div class="flex-1 flex flex-col overflow-hidden">

                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">

                        <div class="container mx-auto px-6 py-8">
                            <form method="GET" action="{{ route('dashboard.movies.list-movies') }}">
                                <input type="text" name="name" placeholder="Search by Title"
                                       class="border border-gray-300 rounded-md p-2 w-540" />

                                   <button type="submit" class="text-center bg-blue-900 rounded-md text-white py-3 font-medium">search</button>
                                </div>
                        </form>
                            <h3 class="text-gray-700 text-3xl font-medium">Genres</h3>
                            <a href="{{ route('dashboard.genres.create-genre') }}">add genre</a>

                            <div class="flex flex-col mt-8">
                                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                    <div
                                            class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                        <table class="min-w-full">
                                            <thead>
                                            <tr>
                                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Heading</th>
                                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                @foreach ($genres as $genre)

                                                <tr>
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">

                                                        <div class="text-sm leading-5 text-dark-900">{{ $genre->name }}</div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                                        <a href="{{ route('dashboard.genres.update-genre', $genre->id) }}" class="text-yellow-600 hover:text-indigo-900">Update</a>
                                                        <a href="{{ route('dashboard.genres.delete-genre' , $genre->id) }}" class="text-red-600 hover:text-red-900">Delete</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>

 @endsection
