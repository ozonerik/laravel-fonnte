<div id="otpDeleteAuthorization" class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
                <h2 class="text-lg font-bold">Otorisasi</h2>
                <p id="confirmDeleteMessage">Please insert the OTP code that sent to your registered number.</p>
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
