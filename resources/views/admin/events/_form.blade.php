<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Date &amp; Time <span class="text-red-500">*</span></label>
        <input type="datetime-local" name="occurred_at"
            value="{{ old('occurred_at', isset($event) ? $event->occurred_at->format('Y-m-d\TH:i') : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('occurred_at') border-red-400 @enderror"
            required>
        @error('occurred_at')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Event Type <span class="text-red-500">*</span></label>
        <select name="event_type" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
            @foreach($eventTypeOptions as $val => $label)
                <option value="{{ $val }}" @selected(old('event_type', isset($event) ? $event->event_type : '') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
        <input type="text" name="location" value="{{ old('location', isset($event) ? $event->location : '') }}"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange"
            placeholder="e.g. New York, NY">
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
        <textarea name="description" rows="3"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('description') border-red-400 @enderror"
            required>{{ old('description', isset($event) ? $event->description : '') }}</textarea>
        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
</div>
