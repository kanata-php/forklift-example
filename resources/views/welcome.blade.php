<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        @livewireStyles
        @livewireScripts

        @vite('resources/js/app.js')

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="antialiased">

        <div
            class="m-auto max-w-screen-lg w-full pt-4"
            x-data="{
                init() {
                    window.addEventListener('{{ \Kanata\Forklift\Events\AssetMoved::EVENT_NAME }}', (e) => {
                        window.location.reload();
                    });
                }
            }"
        >

            <h1 class="text-2xl">Home</h1>

            <div class="p-4"><strong>Moved asset:</strong> {{ $document->title }}</div>

            <div class="p-4">
                <strong>Breadcrumb:</strong>
                <ul class="flex gap-2">
                    @php $currentLocation = $document->directory; @endphp
                    @if($currentLocation !== null)
                        <li>{{ $currentLocation->title }}</li>
                        <li>/</li>
                    @endif
                    @while(null !== $currentLocation && $currentLocation->parent !== null)
                        <li>{{ $currentLocation->parent_directory->title }}</li>
                        <li>/</li>
                        @php $currentLocation = $currentLocation->parent_directory; @endphp
                    @endwhile
                    <li>Root</li>
                </ul>
            </div>

            <div class="p-4">
                @livewire('forklift-dropdown', [
                    'currentLocationId' => $document->directory_id,
                    'locationType' => \App\Models\Directory::class,
                    'assetId' => $document->id,
                    'assetType' => \App\Models\Document::class,
                    'assetRepository' => App\Repositories\AssetRepository::class,
                    'parentField' => 'directory_id',
                ])
            </div>

            <div class="p-4">
                <strong>Local Locations:</strong>
                <ul class="mt-4">
                    @foreach($document->directory?->children ?? \App\Models\Directory::whereNull('parent')->get() as $direcory)
                        <li class="flex">
                            <svg class="w-5 h-5 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                            {{ $direcory->title }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="p-4">
                <strong>Local Assets:</strong>
                <ul class="mt-4">
                    @foreach(\App\Models\Document::where('directory_id', $document->directory)->get() as $current_doc)
                        <li class="flex">
                            <svg class="w-5 h-5 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            {{ $current_doc->title }} @if($current_doc->id === $document->id) (current asset) @endif
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </body>
</html>
