<x-app-layout>
    <x-principal>
        <div
            class="w-full mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

            <img class="w-full h-80 rounded bg-center bg-no-repeat bg-cover" src="{{ Storage::url($article->imagen) }}"
                alt="" />

            <div class="p-5">

                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $article->titulo }}
                </h5>

                <blockquote class="text-lg italic font-semibold text-left text-gray-900 dark:text-white">
                    <p>"&nbsp;{{ $article->contenido }}&nbsp;"</p>
                <blockquote/>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    <span class="font-bold">Autor: </span>
                    <span class="italic text-green-500 dark:text-green-200">{{ $article->user->email }}</span>
                </p>
                <p class="mb-3  text-gray-700 dark:text-gray-400">
                    <span class="font-bold">Categoría: </span>
                    <span class="p-1 rounded text-center" style="background-color: {{ $article->category->color }}">
                        {{ $article->category->nombre }}
                    </span>
                </p>
                <p class="mb-3  text-gray-700 dark:text-gray-400">
                    <span class="font-bold">Creado: </span>
                    <span class="italic text-blue-400 dark:text-blue-200">
                        {{ $article->created_at->format('d/m/Y h:i:s') }}
                    </span>
                </p>
                <p class="mb-3  text-gray-700 dark:text-gray-400">
                    <span class="font-bold">ESTADO: </span>
                    <span @class([
                        'text-red-600 dark:text-red-300' => $article->estado == 'BORADOR',
                        'text-green-600 dark:text-green-300' => $article->estado == 'PUBLICADO',
                    ])>{{ $article->estado }}</span>
                </p>
                <p class="mb-3  text-gray-700 dark:text-gray-400">
                    <span class="font-bold">Total Likes: </span>
                    {{ $article->usersLike->count() }} <i class="fa-solid fa-heart text-red-500 hover:text-red-300"></i>
                </p>
                <div class="ml-2 mb-3">
                    <ol class="list-decimal">
                        @foreach ($article->usersLike as $user)
                            <li class="italic text-blue-500 dark:text-blue-300 mr-1 text-sm">
                                {{ $user->email }}
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div class="flex flex-row-reverse">
                    <button type="button" onclick="history.go(-1)"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <i class="fa-solid fa-backward mr-2"></i>VOLVER
                    </button>
                </div>

            </div>
        </div>

    </x-principal>
</x-app-layout>
