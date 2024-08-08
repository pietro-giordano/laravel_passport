<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
            {{ __('Add new client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-validation-errors class="mb-4"></x-validation-errors>

            <x-mary-form action="{{ route('admin.clients.store') }}" method="POST">
                @csrf
                <x-mary-input label="Name" id="name" name="name" value="{{ old('name') }}" />
                <x-input-error for="name"></x-input-error>

                <x-mary-input label="Redirect" id="redirect" name="redirect" value="{{ old('redirect') }}"
                    placeholder="https://www.example.com" />
                <x-input-error for="redirect"></x-input-error>

                <x-slot:actions>
                    <x-mary-button>
                        <a href="{{ route('admin.clients.index') }}">Back</a>
                    </x-mary-button>
                    <x-mary-button label="Create" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
            </x-mary-form>

        </div>
    </div>
</x-app-layout>
