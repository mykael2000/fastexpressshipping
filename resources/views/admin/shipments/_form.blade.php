@php $isEdit = isset($shipment) && $shipment; @endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Number <span class="text-red-500">*</span></label>
        <input type="text" name="tracking_number" value="{{ old('tracking_number', $isEdit ? $shipment->tracking_number : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('tracking_number') border-red-400 @enderror"
            placeholder="e.g. FES1234567890" {{ $isEdit ? '' : 'required' }}>
        @error('tracking_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
        <select name="status" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
            @foreach($statusOptions as $val => $label)
                <option value="{{ $val }}" @selected(old('status', $isEdit ? $shipment->status : 'created') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Origin <span class="text-red-500">*</span></label>
        <input type="text" name="origin" value="{{ old('origin', $isEdit ? $shipment->origin : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('origin') border-red-400 @enderror" required>
        @error('origin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Destination <span class="text-red-500">*</span></label>
        <input type="text" name="destination" value="{{ old('destination', $isEdit ? $shipment->destination : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('destination') border-red-400 @enderror" required>
        @error('destination')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Recipient Name <span class="text-red-500">*</span></label>
        <input type="text" name="recipient_name" value="{{ old('recipient_name', $isEdit ? $shipment->recipient_name : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('recipient_name') border-red-400 @enderror" required>
        @error('recipient_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Recipient Email</label>
        <input type="email" name="recipient_email" value="{{ old('recipient_email', $isEdit ? $shipment->recipient_email : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('recipient_email') border-red-400 @enderror">
        @error('recipient_email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Recipient Phone</label>
        <input type="text" name="recipient_phone" value="{{ old('recipient_phone', $isEdit ? $shipment->recipient_phone : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('recipient_phone') border-red-400 @enderror"
            placeholder="+1 555 000 0000">
        @error('recipient_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Service Level <span class="text-red-500">*</span></label>
        <select name="service_level" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
            @foreach($serviceLevelOptions as $val => $label)
                <option value="{{ $val }}" @selected(old('service_level', $isEdit ? $shipment->service_level : 'standard') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Shipped Date</label>
        <input type="datetime-local" name="shipped_date" value="{{ old('shipped_date', $isEdit && $shipment->shipped_date ? $shipment->shipped_date->format('Y-m-d\TH:i') : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Delivery</label>
        <input type="datetime-local" name="eta" value="{{ old('eta', $isEdit && $shipment->eta ? $shipment->eta->format('Y-m-d\TH:i') : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
    <textarea name="notes" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('notes') border-red-400 @enderror">{{ old('notes', $isEdit ? $shipment->notes : '') }}</textarea>
    @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div class="flex gap-6">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="hidden" name="notify_email" value="0">
        <input type="checkbox" name="notify_email" value="1" @checked(old('notify_email', $isEdit ? $shipment->notify_email : true))
            class="w-4 h-4 text-fes-orange border-gray-300 rounded focus:ring-fes-orange">
        <span class="text-sm text-gray-700">Email notifications</span>
    </label>
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="hidden" name="notify_sms" value="0">
        <input type="checkbox" name="notify_sms" value="1" @checked(old('notify_sms', $isEdit ? $shipment->notify_sms : false))
            class="w-4 h-4 text-fes-orange border-gray-300 rounded focus:ring-fes-orange">
        <span class="text-sm text-gray-700">SMS notifications</span>
    </label>
</div>
