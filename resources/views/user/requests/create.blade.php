<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Submit Shipment Request</h2>
            <a href="{{ route('user.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4">

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    <p class="font-semibold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.requests.store') }}" x-data="packageManager()" class="space-y-8">
                @csrf

                {{-- ── 1. Sender Information ── --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-fes-navy px-6 py-4">
                        <h3 class="text-white font-semibold flex items-center gap-2">
                            <span class="w-6 h-6 bg-fes-orange rounded-full text-xs flex items-center justify-center font-bold">1</span>
                            Sender Information
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @php
                        $senderFields = [
                            ['name'=>'sender_name',    'label'=>'Full Name',       'type'=>'text',  'col'=>'sm:col-span-2'],
                            ['name'=>'sender_email',   'label'=>'Email',           'type'=>'email', 'col'=>''],
                            ['name'=>'sender_phone',   'label'=>'Phone',           'type'=>'tel',   'col'=>''],
                            ['name'=>'sender_address1','label'=>'Address Line 1',  'type'=>'text',  'col'=>'sm:col-span-2'],
                            ['name'=>'sender_address2','label'=>'Address Line 2 (optional)', 'type'=>'text', 'col'=>'sm:col-span-2'],
                            ['name'=>'sender_city',    'label'=>'City',            'type'=>'text',  'col'=>''],
                            ['name'=>'sender_state',   'label'=>'State / Province','type'=>'text',  'col'=>''],
                            ['name'=>'sender_postal',  'label'=>'Postal Code',     'type'=>'text',  'col'=>''],
                            ['name'=>'sender_country', 'label'=>'Country',         'type'=>'text',  'col'=>''],
                        ];
                        @endphp
                        @foreach($senderFields as $f)
                        <div class="{{ $f['col'] }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $f['label'] }}</label>
                            <input type="{{ $f['type'] }}" name="{{ $f['name'] }}" value="{{ old($f['name']) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange focus:border-transparent @error($f['name']) border-red-400 @enderror">
                            @error($f['name'])<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── 2. Recipient Information ── --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-fes-navy px-6 py-4">
                        <h3 class="text-white font-semibold flex items-center gap-2">
                            <span class="w-6 h-6 bg-fes-orange rounded-full text-xs flex items-center justify-center font-bold">2</span>
                            Recipient Information
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @php
                        $recipientFields = [
                            ['name'=>'recipient_name',    'label'=>'Full Name',       'type'=>'text',  'col'=>'sm:col-span-2'],
                            ['name'=>'recipient_email',   'label'=>'Email',           'type'=>'email', 'col'=>''],
                            ['name'=>'recipient_phone',   'label'=>'Phone',           'type'=>'tel',   'col'=>''],
                            ['name'=>'recipient_address1','label'=>'Address Line 1',  'type'=>'text',  'col'=>'sm:col-span-2'],
                            ['name'=>'recipient_address2','label'=>'Address Line 2 (optional)', 'type'=>'text', 'col'=>'sm:col-span-2'],
                            ['name'=>'recipient_city',    'label'=>'City',            'type'=>'text',  'col'=>''],
                            ['name'=>'recipient_state',   'label'=>'State / Province','type'=>'text',  'col'=>''],
                            ['name'=>'recipient_postal',  'label'=>'Postal Code',     'type'=>'text',  'col'=>''],
                            ['name'=>'recipient_country', 'label'=>'Country',         'type'=>'text',  'col'=>''],
                        ];
                        @endphp
                        @foreach($recipientFields as $f)
                        <div class="{{ $f['col'] }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $f['label'] }}</label>
                            <input type="{{ $f['type'] }}" name="{{ $f['name'] }}" value="{{ old($f['name']) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange focus:border-transparent @error($f['name']) border-red-400 @enderror">
                            @error($f['name'])<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── 3. Package Details ── --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-fes-navy px-6 py-4 flex items-center justify-between">
                        <h3 class="text-white font-semibold flex items-center gap-2">
                            <span class="w-6 h-6 bg-fes-orange rounded-full text-xs flex items-center justify-center font-bold">3</span>
                            Package Details
                        </h3>
                        <button type="button" @click="addPackage()"
                                class="bg-fes-orange text-white text-xs font-semibold px-4 py-1.5 rounded-lg hover:bg-orange-600 transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Package
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <template x-for="(pkg, index) in packages" :key="index">
                            <div class="border border-gray-200 rounded-xl p-5 relative">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-gray-700 text-sm" x-text="'Package ' + (index + 1)"></h4>
                                    <button type="button" @click="removePackage(index)" x-show="packages.length > 1"
                                            class="text-red-400 hover:text-red-600 text-xs transition">Remove</button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Package Type</label>
                                        <select :name="'packages[' + index + '][package_type]'"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                            <option value="box">Box</option>
                                            <option value="envelope">Envelope</option>
                                            <option value="pallet">Pallet</option>
                                            <option value="tube">Tube</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Quantity</label>
                                        <input type="number" :name="'packages[' + index + '][quantity]'" min="1" value="1"
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Weight</label>
                                        <div class="flex gap-2">
                                            <input type="number" step="0.01" :name="'packages[' + index + '][weight]'" placeholder="0.00"
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                            <select :name="'packages[' + index + '][weight_unit]'"
                                                    class="border border-gray-300 rounded-lg px-2 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                                <option value="kg">kg</option>
                                                <option value="lb">lb</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-2 lg:col-span-1">
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Dimensions (L × W × H)</label>
                                        <div class="flex gap-1 items-center">
                                            <input type="number" step="0.1" :name="'packages[' + index + '][length]'" placeholder="L"
                                                   class="w-full border border-gray-300 rounded-lg px-2 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                            <span class="text-gray-400 text-xs">×</span>
                                            <input type="number" step="0.1" :name="'packages[' + index + '][width]'" placeholder="W"
                                                   class="w-full border border-gray-300 rounded-lg px-2 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                            <span class="text-gray-400 text-xs">×</span>
                                            <input type="number" step="0.1" :name="'packages[' + index + '][height]'" placeholder="H"
                                                   class="w-full border border-gray-300 rounded-lg px-2 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                            <select :name="'packages[' + index + '][dimension_unit]'"
                                                    class="border border-gray-300 rounded-lg px-1 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                                <option value="cm">cm</option>
                                                <option value="in">in</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Declared Value</label>
                                        <div class="flex gap-2">
                                            <input type="number" step="0.01" :name="'packages[' + index + '][declared_value]'" placeholder="0.00"
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                            <select :name="'packages[' + index + '][currency]'"
                                                    class="border border-gray-300 rounded-lg px-2 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                                <option value="USD">USD</option>
                                                <option value="EUR">EUR</option>
                                                <option value="GBP">GBP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">HS Code (international)</label>
                                        <input type="text" :name="'packages[' + index + '][hs_code]'" placeholder="e.g. 8471.30"
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                    </div>
                                    <div class="sm:col-span-2 lg:col-span-3">
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Contents Description</label>
                                        <input type="text" :name="'packages[' + index + '][contents_description]'" placeholder="Brief description of package contents"
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- ── 4. Pickup & Delivery ── --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ pickupType: '{{ old('pickup_type', 'dropoff') }}' }">
                    <div class="bg-fes-navy px-6 py-4">
                        <h3 class="text-white font-semibold flex items-center gap-2">
                            <span class="w-6 h-6 bg-fes-orange rounded-full text-xs flex items-center justify-center font-bold">4</span>
                            Pickup &amp; Delivery
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Type</label>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <label class="flex items-center gap-3 border border-gray-200 rounded-lg px-4 py-3 cursor-pointer hover:border-fes-orange transition flex-1">
                                    <input type="radio" name="pickup_type" value="dropoff" x-model="pickupType" class="text-fes-orange">
                                    <div>
                                        <p class="font-medium text-sm text-gray-800">Drop-off</p>
                                        <p class="text-xs text-gray-400">I'll bring it to a drop-off location</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 border border-gray-200 rounded-lg px-4 py-3 cursor-pointer hover:border-fes-orange transition flex-1">
                                    <input type="radio" name="pickup_type" value="scheduled" x-model="pickupType" class="text-fes-orange">
                                    <div>
                                        <p class="font-medium text-sm text-gray-800">Scheduled Pickup</p>
                                        <p class="text-xs text-gray-400">A courier will come to me</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div x-show="pickupType === 'scheduled'" class="grid grid-cols-1 sm:grid-cols-2 gap-5 border-t border-gray-100 pt-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Date</label>
                                <input type="date" name="pickup_date" value="{{ old('pickup_date') }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                @error('pickup_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Time Window</label>
                                <select name="time_window" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                                    <option value="">Select window</option>
                                    <option value="morning" {{ old('time_window') === 'morning' ? 'selected' : '' }}>Morning (8am–12pm)</option>
                                    <option value="afternoon" {{ old('time_window') === 'afternoon' ? 'selected' : '' }}>Afternoon (12pm–5pm)</option>
                                    <option value="evening" {{ old('time_window') === 'evening' ? 'selected' : '' }}>Evening (5pm–8pm)</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Instructions (optional)</label>
                                <textarea name="pickup_instructions" rows="2"
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">{{ old('pickup_instructions') }}</textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 border-t border-gray-100 pt-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Service Level</label>
                                <select name="service_level" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('service_level') border-red-400 @enderror">
                                    <option value="">Select service</option>
                                    <option value="standard" {{ old('service_level') === 'standard' ? 'selected' : '' }}>Standard (3–5 days)</option>
                                    <option value="express" {{ old('service_level') === 'express' ? 'selected' : '' }}>Express (1–2 days)</option>
                                    <option value="overnight" {{ old('service_level') === 'overnight' ? 'selected' : '' }}>Overnight (next day by 10:30 AM)</option>
                                </select>
                                @error('service_level')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="flex flex-col gap-3 justify-center">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="signature_required" value="1" {{ old('signature_required') ? 'checked' : '' }} class="rounded text-fes-orange">
                                    <span class="text-sm text-gray-700">Signature Required</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="insurance_required" value="1" {{ old('insurance_required') ? 'checked' : '' }} class="rounded text-fes-orange">
                                    <span class="text-sm text-gray-700">Add Cargo Insurance</span>
                                </label>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Instructions (optional)</label>
                                <textarea name="delivery_instructions" rows="2"
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">{{ old('delivery_instructions') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── 5. Compliance ── --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-fes-navy px-6 py-4">
                        <h3 class="text-white font-semibold flex items-center gap-2">
                            <span class="w-6 h-6 bg-fes-orange rounded-full text-xs flex items-center justify-center font-bold">5</span>
                            Compliance &amp; Terms
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="prohibited_items_acknowledged" value="1" {{ old('prohibited_items_acknowledged') ? 'checked' : '' }} class="rounded text-fes-orange mt-0.5 flex-shrink-0">
                            <span class="text-sm text-gray-700">I confirm that my shipment does <strong>not</strong> contain any prohibited items, including but not limited to: hazardous materials, illegal substances, firearms, live animals, or cash. I understand that false declarations may result in shipment seizure and legal liability.</span>
                        </label>
                        @error('prohibited_items_acknowledged')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror

                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="terms_accepted" value="1" {{ old('terms_accepted') ? 'checked' : '' }} class="rounded text-fes-orange mt-0.5 flex-shrink-0">
                            <span class="text-sm text-gray-700">I have read and agree to the <a href="{{ route('pages.show', 'terms-of-service') }}" class="text-fes-orange hover:underline" target="_blank">Terms of Service</a> and <a href="{{ route('pages.show', 'privacy-policy') }}" class="text-fes-orange hover:underline" target="_blank">Privacy Policy</a>.</span>
                        </label>
                        @error('terms_accepted')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── 6. Additional Notes ── --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-fes-navy px-6 py-4">
                        <h3 class="text-white font-semibold flex items-center gap-2">
                            <span class="w-6 h-6 bg-fes-orange rounded-full text-xs flex items-center justify-center font-bold">6</span>
                            Additional Notes
                        </h3>
                    </div>
                    <div class="p-6">
                        <textarea name="notes" rows="4" placeholder="Any other details, special instructions, or questions for our team…"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- ── Submit ── --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('user.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    <button type="submit" class="bg-fes-orange text-white font-semibold px-10 py-3 rounded-lg hover:bg-orange-600 transition text-sm">
                        Submit Shipment Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function packageManager() {
            return {
                packages: [{}],
                addPackage() {
                    this.packages.push({});
                },
                removePackage(index) {
                    if (this.packages.length > 1) {
                        this.packages.splice(index, 1);
                    }
                }
            };
        }
    </script>
</x-app-layout>
