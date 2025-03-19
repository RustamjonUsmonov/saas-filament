<x-filament-widgets::widget class="col-span-full">
    <x-filament::section class="inspiration-widget overflow-hidden relative">
        <div class="absolute top-0 right-0 w-16 h-16 -mt-4 -mr-4">
            <div class="text-primary-100 dark:text-primary-900 opacity-30 transform rotate-12">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12">
                    <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                </svg>
            </div>
        </div>

        <div class="pt-2 pb-3">
            <blockquote class="pl-4 border-l-4 border-primary-300 dark:border-primary-700">
                <p class="text-gray-800 dark:text-gray-200 italic font-serif leading-relaxed">
                    {{ $quote }}
                </p>
            </blockquote>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
