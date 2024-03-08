<x-principal>
    <div class="flex w-full mb-2 items-center justify-between">
        <div class="flex-1 w-3/4">
            <x-input type="search" class="w-3/4 mr-1" placeholder="Buscar ..." wire:model.live="search" />
            <i class="fas fa-search"></i>
        </div>
        <div>
            <x-button class="mr-4" wire:click="$set('openModalLikes', true)">
                <i class="fa-solid fa-thumbs-up mr-2"></i>Ver Mis likes
            </x-button>
        </div>
        <div class="">
            @livewire('create-article')
        </div>
    </div>
    @if ($articulos->count())
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        DETALLE
                    </th>

                    <th scope="col" class="px-6 py-3">
                        IMAGEN
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('titulo')">
                        <i class="fas fa-sort mr-1"></i>TITULO
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                        <i class="fas fa-sort mr-1"></i>CATEGORIA
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('estado')">
                        <i class="fas fa-sort mr-1"></i>ESTADO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <a href="{{ route('articles.show', $item->id_art) }}">
                                <i
                                    class="fas fa-circle-info text-blue-500 dark:text-blue-300 text-2xl hover:text-4xl"></i>
                            </a>
                        </td>
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-24 h-24 rounded bbg-cover bg-center" src="{{ Storage::url($item->imagen) }}"
                                alt="{{ $item->titulo }}" />

                        </th>
                        <td class="px-6 py-4 text-lg dark:text-gray-100 text-gray-600">
                            {{ $item->titulo }}
                        </td>
                        <td class="px-6 py-4 text-black">
                            <div class="text-center p-1 rounded-lg" style="background-color: {{ $item->color }}">
                                {{ $item->nombre }}</div>
                        </td>
                        <td class="px-6 py-4 dark:text-gray-100 text-gray-600">
                            <div class="flex items-center cursor-pointer"
                                wire:click="cambiarEstado({{ $item->id_art }})">
                                <div @class([
                                    'h-3.5 w-3.5 rounded-full me-2',
                                    'bg-green-500' => $item->estado == 'PUBLICADO',
                                    'bg-red-500' => $item->estado == 'BORRADOR',
                                ])></div> {{ $item->estado }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="editar({{ $item->id_art }})" class="mr-2">
                                <i class="fas fa-edit hover:text-2xl text-blue-500 dark:text-blue-300"></i>
                            </button>
                            <button wire:click="pedirPermisoBorrar({{ $item->id_art }})">
                                <i class="fas fa-trash hover:text-2xl text-red-500 dark:text-red-300"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-1">
            {{ $articulos->links() }}
        </div>
    @else
        <div class="p-4 bg-gray-700 rounded-xl text-xl shadow-xl text-white">
            <i class="fa-solid fa-triangle-exclamation mr-4"></i>No se encontró ningún artículo o aún no ha creado
            niguuno, aproveche para crear el primero.
        </div>
    @endif
    <!-- ---------------------------------------------------------- MODAL PARA EDITAR -------------------------------->
    @isset($form->articulo)
        <x-dialog-modal wire:model='openModalEditar'>
            <x-slot name="title">
                <div class="w-full text-center">EDITAR ARTÍCULO</div>
            </x-slot>
            <x-slot name="content">
                <!-- Pinto el Formulario -->
                <x-label for="titulo1">Título del Artículo</x-label>
                <x-input id="titulo1" placeholder="Título..." class="w-full mb-2" wire:model="form.titulo" />
                <x-input-error for="form.titulo" />

                <x-label for="contenido1">Contenido del Artículo</x-label>
                <textarea rows='4' class="w-full rounded mb-2" placeholder="Contenido..."
                    wire:model="form.contenido"id="contenido1"></textarea>
                <x-input-error for="form.contenido" />

                <x-label for="category_id1">Categoria del Artículo</x-label>
                <select class="w-full rounded mb-2" id="category_id1" wire:model="form.category_id">
                    <option>Selecciona una categoría</option>
                    @foreach ($categorias as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.category_id" />

                <x-label for="estado2">Publicar artículo</x-label>
                <div class="flex items-center mb-2">
                    <input id="estado2" type="checkbox" value="PUBLICADO" wire:model="form.estado"
                        @checked($form->estado == 'PUBLICADO')
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-100 dark:border-gray-600">
                    <label for="estado2" class="ms-2 text-sm font-medium text-gray-700">Publicar</label>
                </div>
                <x-input-error for="form.estado" />

                <x-label for="imagenU">Imagen del artículo</x-label>
                <div class="w-full h-72 rounded relative bg-gray-200">
                    @if ($form->imagen)
                        <img src="{{ $form->imagen->temporaryUrl() }}"
                            class="bg-cover bg-center bg-no-repeat w-full h-72" />
                    @else
                        <img src="{{ Storage::url($form->articulo->imagen) }}"
                            class="bg-cover bg-center bg-no-repeat w-full h-72" />
                    @endif

                    <input type="file" accept="image/*" id="imagenU" hidden wire:model="form.imagen" />
                    <label for="imagen1"
                        class="absolute bottom-2 right-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-cloud-arrow-up mr-1"></i>Upload</label>
                </div>
                <x-input-error for="form.imagen" />

            </x-slot>
            <x-slot name="footer">
                <div class="flex flex-row-reverse">
                    <button wire:click="update"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit"></i> EDITAR
                    </button>

                    <button wire:click="limpiarUpdate"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR
                    </button>
                </div>
            </x-slot>

        </x-dialog-modal>
    @endisset
    <!-- Modal para ver mis likes ----------------------------------------------------------------------->
    <x-dialog-modal wire:model='openModalLikes'>
        <x-slot name="title">
            <div class="w-full text-center">MIS ARTÍCULOS FAVORITOS</div>
        </x-slot>
        <x-slot name="content">
            <ul class="list-decimal">
                @foreach ($misLikes as $item)
                    <li class="grid grid-cols-2 gap-4 items-center hover:bg-gray-200">
                        <div class="text-blue-600 font-semibold text-start hover:text-xl">
                            <a href="{{ route('articles.show', $item) }}">
                                {{ $item->titulo }}
                            </a>
                        </div>
                        <div class="italic">
                            &lt;{{ $item->user->email }}&gt;
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="mt-2">
                <span class="font-bold">TOTAL: </span> {{ $misLikes->count() }} Likes
            </div>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$set('openModalLikes', false)"
                class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-xmark"></i> CERRAR
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- FIn MODAL                ----------------------------------------------------------------------->
</x-principal>
