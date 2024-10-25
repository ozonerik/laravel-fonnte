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
        if (navigator.clipboard) {
            navigator.clipboard.writeText(token).then(() => {
                showNotification(token);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = token;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                console.log('Fallback: Token copied successfully');
                showNotification(token);
            } catch (err) {
                console.error('Fallback: Failed to copy', err);
            }
            document.body.removeChild(textArea);
        }
    }

    function showNotification(token) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notificationMessage');
        if (notification && notificationMessage) {
            notificationMessage.innerText = 'Token copied to clipboard: ' + token;
            notification.classList.remove('hidden'); // Show the notification

            setTimeout(() => {
                notification.classList.add('hidden');
            }, 2000);
        }
    }
</script>
