<x-principal>
    <!-- Mostraremos los productos disponbles en un grid -->
    <div class="mb-2">
        <x-input type="search" class="w-1/2" wire:model.live="search" placeholder="Buscar por título..." />
        <i class="ml-2 fa-solid fa-magnifying-glass"></i>

    </div>
    @if ($articulos->count())
        <div class="w-full p-2 border-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach ($articulos as $item)
                <article @class([
                    'h-72 bg-cover bg-center bg-no-repeat z-0',
                    'md:col-span-2' => $loop->first,
                ]) style="background-image: url({{ Storage::url($item->imagen) }})">
                    <div
                        class="w-full h-full flex flex-col justify-around items-center p-2
                          relative bg-gray-100 bg-opacity-40">
                        <div class="text-xl font-bold">
                            <a href="{{ route('articles.show', $item) }}">
                                {{ $item->titulo }}
                            </a>
                        </div>
                        <div class="italic text-blue-900">
                            {{ $item->user->email }}
                        </div>
                        <div class="p-2 rounded-lg bg-opacity-50"
                            style="background-color: {{ $item->category->color }}">
                            {{ $item->category->nombre }}
                        </div>
                        <div class="flex absolute bottom-2 end-4 bg-gray-200 px-2 rounded-lg">
                            <div class="mr-4">
                                <i class="fas fa-heart text-red-500"></i>
                            </div>
                            <div>
                                {{ $item->usersLike->count() }}
                            </div>

                        </div>
                        @auth
                            <div class="flex absolute bottom-2 start-4 bg-gray-400 px-2 rounded-lg hover:text-3xl">
                                <button wire:click="like({{ $item->id }})">
                                    <i @class([
                                        'fas fa-thumbs-up',
                                        'text-purple-700' => in_array($item->id, $articulosLikes),
                                        'text-white' => !in_array($item->id, $articulosLikes),
                                    ])></i>
                                    @if (in_array($item->id, $articulosLikes))
                                        <span class="italic text-sm">Me Gusta!!</span>
                                    @endif
                                </button>
                            </div>
                        @endauth
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-2">
            {{ $articulos->links() }}
        </div>
    @else
        <div class="p-4 bg-gray-700 rounded-xl text-xl shadow-xl text-white">
            <i class="fa-solid fa-triangle-exclamation mr-4"></i>No se encontró ningún artículo con ese título.
        </div>
    @endif
</x-principal>
