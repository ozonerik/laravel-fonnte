<div class="px-4 py-5 sm:p-6">
    <h2 class="mb-4 text-lg font-semibold text-gray-900">Device Details</h2>

    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Device Name:</dt>
            <dd class="text-gray-900">{{ $response['data']['name'] }}</dd>
        </div>
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Phone Number:</dt>
            <dd class="text-gray-900">{{ $response['data']['device'] }}</dd>
        </div>
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Device Status:</dt>
            <dd class="text-{{ $response['data']['device_status'] === 'connected' ? 'green-600' : 'red-600' }}">
                {{ ucfirst($response['data']['device_status']) }}
            </dd>
        </div>
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Package:</dt>
            <dd class="text-gray-900">{{ $response['data']['package'] }}</dd>
        </div>
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Quota:</dt>
            <dd class="text-gray-900">{{ $response['data']['quota'] }} messages</dd>
        </div>
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Messages Sent:</dt>
            <dd class="text-gray-900">{{ $response['data']['messages'] }}</dd>
        </div>
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Expired:</dt>
            <dd class="text-gray-900">{{ $response['data']['expired'] }}</dd>
        </div>
        <div class="pb-2 border-b">
            <dt class="font-medium text-gray-700">Attachment:</dt>
            <dd class="text-gray-900">{{ $response['data']['attachment'] ? 'Yes' : 'No' }}</dd>
        </div>
    </dl>
</div>
