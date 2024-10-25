<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Add New Device') }}</h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('devices.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Device Name</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="device" class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                    <input type="text" name="device" id="device" required value="{{ old('device') }}"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600">
                    Add Device
                </button>
                <a href="{{ route('devices.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 font-semibold text-white rounded bg-slate-500 hover:bg-slate-600">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</x-app-layout>
