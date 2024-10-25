<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Devices') }}</h2>
    </x-slot>

    <div class="py-5">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">All Devices</h1>
                <a href="{{ route('devices.create') }}"
                    class="px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600">
                    Add New Device
                </a>
            </div>

            @if (session('success'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500" role="alert">
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <div id="notification" class="hidden p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500"
                    role="alert">
                    <p id="notificationMessage" class="font-bold"></p>
                </div>

                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Phone</th>
                            <th class="px-6 py-3 text-left">Token</th>
                            <th class="px-6 py-3 text-left">Quota</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $index => $device)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $index + 1 }}</td>
                                <td class="px-6 py-3">{{ $device['name'] }}</td>
                                <td class="px-6 py-3">{{ $device['device'] }}</td>
                                <td class="px-6 py-3">
                                    <button
                                        class="px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600"
                                        onclick="copyToClipboard('{{ $device['token'] }}')">
                                        Copy Token
                                    </button>
                                </td>
                                <td class="px-6 py-3">{{ $device['quota'] }}</td>
                                <td class="px-6 py-3">
                                    @if ($device['status'] === 'connect')
                                        <span class="px-4 py-2 font-semibold text-white bg-green-500 rounded">
                                            Connected
                                        </span>
                                    @else
                                        <span class="px-4 py-2 font-semibold text-white bg-red-500 rounded">
                                            Disconnect
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 space-x-2">
                                    @if ($device['status'] === 'connect')
                                        <button class="px-4 py-2 text-white rounded bg-slate-500"
                                            onclick="openSendMessageModal('{{ $device['token'] }}')">
                                            Send Message
                                        </button>
                                        <button class="px-4 py-2 text-white bg-red-500 rounded disconnectButton"
                                            data-device-token="{{ $device['token'] }}"
                                            onclick="disconnectDevice('{{ $device['token'] }}')">
                                            Disconnect
                                            <svg class="hidden w-5 h-5 ml-2 text-white disconnectSpinner animate-spin"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                        </button>
                                    @else
                                        <button class="px-4 py-2 text-white bg-green-500 rounded"
                                            onclick="activateDevice('{{ $device['token'] }}', this)">
                                            Connect
                                        </button>
                                    @endif
                                    <button class="px-4 py-2 text-white bg-orange-500 rounded"
                                        onclick="confirmDelete('{{ $device['token'] }}', '{{ $device['name'] }}')">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Device Details -->
    <div id="deviceModal" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <div id="modalContent">Loading...</div>
                <button class="mt-4 text-red-500 hover:underline" onclick="closeDeviceModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal for Confirmation -->
    <div id="confirmDeleteModal" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <h2 class="text-lg font-bold">Confirm Delete</h2>
                <p id="confirmDeleteMessage">Are you sure you want to delete this device?</p>
                <div class="flex justify-end mt-4">
                    <button class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                        onclick="deleteDevice()">Delete</button>
                    <button class="px-4 py-2 ml-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100"
                        onclick="closeConfirmDeleteModal()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div id="otpDeleteAuthorization" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <h2 class="text-lg font-bold">Otorisasi</h2>
                <p id="confirmDeleteMessage">Masukan kode OTP yang dikirimkan ke nomor ini</p>
                <div id="errorContainerOTP" class="hidden mb-4">
                    <p class="font-medium text-red-500" id="errorMessageOTP"></p>
                </div>
                <form id="otpAuthorizationForm">
                    <input class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                        name="otp" required />
                    <div class="flex justify-end mt-4">
                        <button class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                            type="submit">Confirm</button>
                        <button class="px-4 py-2 ml-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100"
                            type="button" onclick="closeOtpDeleteAuthorization()">Cancel</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Modal for displaying the QR code -->
    <div id="deviceModal" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <div id="modalContent">Loading...</div>
                <button class="mt-4 text-red-500 hover:underline" onclick="closeDeviceModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal Send Message -->
    <div id="sendMessageModal" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <h2 class="mb-4 text-lg font-semibold">Send Message</h2>

                <!-- Error message container -->
                <div id="errorContainer" class="hidden mb-4">
                    <p class="font-medium text-red-500" id="errorMessage"></p>
                </div>

                <form id="sendMessageForm">
                    <div class="mb-4">
                        <label for="target" class="block mb-2 font-medium">Target</label>
                        <input type="text" name="target" id="target" required
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block mb-2 font-medium">Message</label>
                        <textarea name="message" id="message" required rows="4"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                    <input type="hidden" name="device_token" id="deviceToken">

                    <div class="flex items-center justify-end space-x-4">
                        <button type="button" class="text-red-500 hover:underline"
                            onclick="closeSendMessageModal()">Close</button>

                        <button type="submit"
                            class="flex items-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600"
                            id="sendMessageButton">
                            <span id="buttonText">Send</span>
                            <svg id="spinner" class="hidden w-5 h-5 ml-2 text-white animate-spin"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Confirmation Disconnect -->
    <div id="confirmDisconnectModal" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <h2 class="text-lg font-bold">Confirm Disconnect</h2>
                <p id="confirmDisconnectMessage">Are you sure you want to disconnect this device?</p>
                <div class="flex justify-end mt-4">
                    <button class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                        onclick="disconnectDeviceConfirmed()">Disconnect</button>
                    <button class="px-4 py-2 ml-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-100"
                        onclick="closeConfirmDisconnectModal()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deviceIdToDelete = null;

        function activateDevice(deviceToken, buttonElement) {
            // Show loading state
            buttonElement.innerHTML = 'Loading...'; // Change button text to "Loading"
            buttonElement.disabled = true; // Disable the button to prevent multiple clicks
            buttonElement.classList.add('bg-gray-400'); // Change color to indicate loading (optional)

            fetch('/devices/activate', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        token: deviceToken
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    buttonElement.innerHTML = 'Connect'; // Reset button text
                    buttonElement.disabled = false; // Enable the button
                    buttonElement.classList.remove('bg-gray-400'); // Reset button color

                    if (data.status) {
                        // Show the QR code in modal
                        const qrImage =
                            `<img src="data:image/png;base64,${data.url}" alt="QR Code" style="width: 200px; height: 200px;">`;
                        document.getElementById('modalContent').innerHTML = qrImage;
                        showModal(); // Function to show the modal
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset button state in case of error
                    buttonElement.innerHTML = 'Connect'; // Reset button text
                    buttonElement.disabled = false; // Enable the button
                    buttonElement.classList.remove('bg-gray-400'); // Reset button color
                });
        }

        function showModal() {
            const modal = document.getElementById('deviceModal');
            modal.classList.remove('hidden'); // Show the modal
        }

        function closeDeviceModal() {
            document.getElementById('deviceModal').classList.add('hidden'); // Hide the modal
            location.reload(); // Refresh the page
        }

        function fetchDeviceStatus() {
            fetch('/devices/status', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        const statusContent = document.getElementById('statusContent');
                        statusContent.innerHTML = '';

                        // Iterate through the devices and display their status
                        data.data.forEach(device => {
                            const deviceInfo = `<div>
                    <strong>${device.name} (${device.device})</strong> - Status: ${device.status}
                </div>`;
                            statusContent.innerHTML += deviceInfo;
                        });

                        document.getElementById('deviceStatus').classList.remove('hidden'); // Show status section
                    } else {
                        alert('Error fetching device status: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function showDeviceModal(deviceId) {
            const modal = document.getElementById('deviceModal');
            modal.classList.remove('hidden');

            document.getElementById('modalContent').innerHTML = 'Loading...';

            fetch(`/devices/${deviceId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('modalContent').innerHTML = data.html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modalContent').innerHTML = 'Failed to load device details.';
                });
        }

        function closeDeviceModal() {
            document.getElementById('deviceModal').classList.add('hidden');
        }

        function disconnectDevice(deviceToken) {
            // Tampilkan loading pada tombol yang sesuai
            const disconnectButton = document.querySelector(`.disconnectButton[data-device-token="${deviceToken}"]`);
            const disconnectSpinner = disconnectButton.querySelector('.disconnectSpinner');

            disconnectButton.disabled = true; // Nonaktifkan tombol
            disconnectSpinner.classList.remove('hidden'); // Tampilkan spinner

            // Lakukan fetch untuk memproses disconnect
            fetch('{{ route('devices.disconnect') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        token: deviceToken
                    })
                })
                .then(response => response.json()) // Parsing respons JSON
                .then(data => {
                    if (data.message) {
                        alert('Device successfully disconnected.');
                        location.reload(); // Refresh halaman setelah sukses
                    } else if (data.error) {
                        alert('Failed to disconnect device: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while disconnecting the device.');
                })
                .finally(() => {
                    // Kembalikan tombol ke keadaan semula
                    disconnectButton.disabled = false; // Aktifkan kembali tombol
                    disconnectSpinner.classList.add('hidden'); // Sembunyikan spinner
                });
        }


        function confirmDelete(deviceId, deviceName) {
            deviceIdToDelete = deviceId; // Store the device ID to delete
            document.getElementById('confirmDeleteMessage').innerText =
                `Are you sure you want to delete the device "${deviceName}"?`;
            document.getElementById('confirmDeleteModal').classList.remove('hidden'); // Show confirmation modal
        }

        function closeConfirmDeleteModal() {
            document.getElementById('confirmDeleteModal').classList.add('hidden'); // Hide confirmation modal
            deviceIdToDelete = null; // Reset the device ID
        }

        function deleteDevice(otp = null) {
            const errorContainer = document.getElementById('errorContainerOTP');
            const errorMessage = document.getElementById('errorMessageOTP');

            errorContainer.classList.remove('hidden');
            if (otp) {

                axios.post('/devices/' + deviceIdToDelete, {
                        '_token': "{{ csrf_token() }}",
                        '_method': "DELETE",
                        'otp': otp
                    }).then((response) => {
                        document.getElementById('otpDeleteAuthorization').classList.add('hidden');
                        deviceIdToDelete = null
                        window.location.reload()
                        return;
                    })
                    .catch((error) => {
                        errorMessage.textContent = error.response.data.error;
                        errorContainer.classList.remove('hidden');
                        return;
                    })
            }

            if (deviceIdToDelete) {
                document.getElementById('otpDeleteAuthorization').classList.remove('hidden');
                document.getElementById('confirmDeleteModal').classList.add('hidden'); // Hide confirmation modal

                let formData = new FormData();

                formData.append('_token', "{{ csrf_token() }}")
                formData.append('_method', "DELETE")

                try {
                    const response = fetch('/devices/' + deviceIdToDelete, {
                        method: 'POST',
                        headers: {
                            'X-Requested-with': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = response.json();

                    console.log(result)
                } catch (error) {
                    console.error('Error:', error);
                }

                return;
            }
        }

        function openSendMessageModal(deviceToken) {
            document.getElementById('deviceToken').value = deviceToken;
            document.getElementById('sendMessageModal').classList.remove('hidden');
            clearError(); // Bersihkan error saat modal dibuka
        }

        function closeSendMessageModal() {
            document.getElementById('sendMessageModal').classList.add('hidden');
            clearError(); // Bersihkan error setelah modal ditutup
        }

        function closeOtpDeleteAuthorization() {
            document.getElementById('otpDeleteAuthorization').classList.add('hidden');
            clearError(); // Bersihkan error setelah modal ditutup
        }

        function clearError() {
            const errorContainer = document.getElementById('errorContainer');
            const errorMessage = document.getElementById('errorMessage');
            errorContainer.classList.add('hidden');
            errorMessage.textContent = '';
        }

        document.getElementById('otpAuthorizationForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            deleteDevice(formData.get('otp'))
        })

        document.getElementById('sendMessageForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const deviceToken = formData.get('device_token');
            const sendButton = document.getElementById('sendMessageButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('spinner');

            // Aktifkan animasi loading
            buttonText.textContent = 'Sending...';
            spinner.classList.remove('hidden');
            sendButton.disabled = true;

            try {
                const response = await fetch('/send-message', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': deviceToken, // Token dikirim di header
                    },
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Pesan berhasil dikirim!');
                    closeSendMessageModal(); // Tutup modal jika berhasil
                } else {
                    // Tampilkan error di modal jika gagal
                    showError(result.error || 'Gagal mengirim pesan.');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Terjadi kesalahan. Coba lagi.');
            } finally {
                // Kembalikan tombol ke keadaan semula
                buttonText.textContent = 'Send';
                spinner.classList.add('hidden');
                sendButton.disabled = false;
            }
        });

        function showSuccess(message) {
            const messageContainer = document.getElementById('messageAlert');
            messageContainer.innerHTML = `<div class="p-4 mb-4 text-green-800 bg-green-100 rounded">${message}</div>`;
        }

        function showError(message) {
            const errorContainer = document.getElementById('errorContainer');
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorContainer.classList.remove('hidden');
        }

        function copyToClipboard(token) {
            navigator.clipboard.writeText(token).then(() => {
                // Show the styled notification
                const notification = document.getElementById('notification');
                const notificationMessage = document.getElementById('notificationMessage');

                notificationMessage.innerText = 'Token copied to clipboard: ' + token;
                notification.classList.remove('hidden'); // Show the notification

                // Hide the notification after 3 seconds
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</x-app-layout>
