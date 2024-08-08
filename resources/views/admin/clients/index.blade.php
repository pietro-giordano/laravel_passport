<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                {{ __('Clients\' list') }}
            </h2>

            <x-mary-button class="btn-outline">
                <a href="{{ route('admin.clients.create') }}" class="uppercase">
                    Add new client
                </a>
            </x-mary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @include('components.success-message')

            @if ($clients)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    @foreach ($clients as $client)
                        <x-mary-list-item :item="$client">
                            <x-slot:value>
                                <div class="text-xl">{{ $client->name }}</div>
                            </x-slot:value>
                            <x-slot:sub-value>
                                <div class="text-xs">Id: {{ $client->id }}</div>
                            </x-slot:sub-value>
                            <x-slot:actions>
                                <x-mary-button icon="o-arrow-path" class="text-yellow-500" />

                                <x-mary-form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-mary-button icon="o-trash" class="text-red-500" type="submit" spinner />
                                </x-mary-form>
                            </x-slot:actions>
                        </x-mary-list-item>
                    @endforeach
                </div>
            @else
                <div>Nessun client registrato!</div>
            @endif

        </div>
    </div>
</x-app-layout>
