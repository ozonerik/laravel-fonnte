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
