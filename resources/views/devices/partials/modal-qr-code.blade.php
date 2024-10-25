<!-- Modal untuk menampilkan QR Code -->
<div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-500 bg-opacity-75">
    <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
        <!-- Keterangan di bagian atas modal -->
        <div class="mb-4">
            <p class="text-lg font-bold text-center mb-7">To use WhatsApp on your computer:</p>
            <ol class="ml-4 text-sm text-gray-700 list-decimal list-inside">
                <li>Open WhatsApp on your phone</li>
                <li>Tap Menu or Settings and select Linked Devices</li>
                <li>Point your phone to this screen to capture the code</li>
                <li>After your smartphone show success message, you can try to refresh this page and voila the device already can send message now</li>
            </ol>
        </div>

        <!-- QR Code atau loading message -->
        <div x-text="loading ? 'Loading...' : ''"></div>
        <div x-show="qrCode" x-html="qrCode" class="flex items-center justify-center p-4"></div>

        <!-- Container tombol close dengan posisi kanan bawah -->
        <div class="flex justify-end mt-4">
            <button @click="isOpen = false; qrCode = '';" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                Close
            </button>
        </div>
    </div>
</div>
