<section class="text-gray-700 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($tags as $tag)
                <div
                    class="flex flex-col bg-white shadow-lg rounded-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl overflow-hidden">
                    <x-filament::section :icon="'phosphor-hash'" :icon-color="'primary'" :class="'mx-4 px-2'" :heading="$tag->name">
                        {{--<div class="px-6 pb-6">
                            <x-filament::button :href="route('filament.admin.resources.product-tags.edit', $tag->id)"
                                                class="text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition-all duration-300">
                                Edit
                            </x-filament::button>
                        </div>--}}
                    </x-filament::section>
                </div>
            @endforeach
        </div>
    </div>
</section>


<x-filament::pagination :paginator="$tags">

</x-filament::pagination>
