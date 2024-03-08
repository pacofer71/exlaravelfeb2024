<div>
    <x-button wire:click="$set('openModalCrear', true)">
        <i class="fas fa-add mr-1"></i> Nuevo
    </x-button>
    <!-- ---------------------------------------------------------- MODAL PARA CREAR -------------------------------->
    <x-dialog-modal wire:model='openModalCrear'>
        <x-slot name="title">
            <div class="w-full text-center">CREAR ARTÍCULO</div>
        </x-slot>
        <x-slot name="content">
            <!-- Pinto el Formulario -->
            <x-label for="titulo">Título del Artículo</x-label>
            <x-input id="titulo" placeholder="Título..." class="w-full mb-2" wire:model="titulo" />
            <x-input-error for="titulo" />

            <x-label for="contenido">Contenido del Artículo</x-label>
            <textarea rows='4' class="w-full rounded mb-2" placeholder="Contenido..." wire:model="contenido"></textarea>
            <x-input-error for="contenido" />

            <x-label for="category_id">Categoria del Artículo</x-label>
            <select class="w-full rounded mb-2" id="category_id" wire:model="category_id">
                <option>Selecciona una categoría</option>
                @foreach ($categorias as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
            <x-input-error for="category_id" />

            <x-label for="estado1">Publicar artículo</x-label>
            <div class="flex items-center mb-2">
                <input id="estado1" type="checkbox" value="PUBLICADO" wire:model="estado"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-100 dark:border-gray-600">
                <label for="estado1" class="ms-2 text-sm font-medium text-gray-700">Publicar</label>
            </div>
            <x-input-error for="estado" />

            <x-label for="imagen1">Imagen del artículo</x-label>
            <div class="w-full h-72 rounded relative bg-gray-200">
                @if ($imagen)
                    <img src="{{ $imagen->temporaryUrl() }}" class="bg-cover bg-center bg-no-repeat w-full h-72" />
                @endif
                <input type="file" accept="image/*" id="imagen1" hidden wire:model="imagen" />
                <label for="imagen1"
                    class="absolute bottom-2 right-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i>Upload</label>
            </div>
            <x-input-error for="imagen" />

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button wire:click="store" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> GUARDAR
                </button>

                <button wire:click="limpiarCrear"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </div>
        </x-slot>

    </x-dialog-modal>
</div>
