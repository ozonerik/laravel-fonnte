<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Device Profile') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Nama:</strong>
                    {{ $response['data']['name'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Phone Number (Device):</strong>
                    {{ $response['data']['device'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Device Status:</strong>
                    {{ $response['data']['device_status'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Expired:</strong>
                    {{ $response['data']['expired'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Package:</strong>
                    {{ $response['data']['package'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Quota:</strong>
                    {{ $response['data']['quota'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Total Messages:</strong>
                    {{ $response['data']['messages'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Status:</strong>
                    {{ $response['data']['status'] ?? 'Tidak Diketahui' }}
                </li>
                <li class="list-group-item">
                    <strong>Token:</strong>
                    {{ $device->token }}
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>
