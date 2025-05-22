<form method="POST" action="{{ route('booths.store') }}" enctype="multipart/form-data"
    class="max-w-lg w-full p-6 bg-white shadow-md rounded-lg space-y-4">
    @csrf

    <div class="grid grid-cols-1 gap-4 text-left">
        {{-- <div class="grid grid-cols-1 md:grid-cols-1 gap-4 w-80"> --}}
            <input type="hidden" name="booth_saved_by" value="1">
            <input type="hidden" name="transport_id" value="1">
            <div>
                <label for="booth_name" class="block text-sm font-medium text-gray-700 mb-1">Booth Name <span
                        class="text-red-500">*</span></label>
                <input type="text" name="booth_name" id="booth_name" value="{{ old('booth_name') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    required>
                @error('booth_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="booth_code" class="block text-sm font-medium text-gray-700 mb-1">Booth Code <span
                        class="text-red-500">*</span></label>
                <input type="number" name="booth_code" id="booth_code" value="{{ old('booth_code') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    required>
                @error('booth_code')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <select name="city_id" id="city_id"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">--Select City--</option>
                    @foreach ($cities as $city)
                    <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="station_id" class="block text-sm font-medium text-gray-700 mb-1">Station</label>
                <select name="station_id" id="station_id"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">--Select Station--</option>
                </select>
            </div>
            <div>
                <label for="booth_man_in_charge_employee_id" class="block text-sm font-medium text-gray-700 mb-1">Man in
                    Charge</label>
                <select name="booth_man_in_charge_employee_id" id="booth_man_in_charge_employee_id"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">--Select Man In Charge--</option>
                    @foreach ($employees as $employee)
                    <option value="{{ $employee->employee_id }}">{{ $employee->employee_name }}</option>
                    @endforeach
                </select>
                @error('booth_man_in_charge_employee_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="booth_address" class="block text-sm font-medium text-gray-700 mb-1">Booth
                    Address</label>
                <input type="text" name="booth_address" id="booth_address" value="{{ old('booth_address') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('booth_address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="booth_phone" class="block text-sm font-medium text-gray-700 mb-1">Booth Phone</label>
                <input type="text" name="booth_phone" id="booth_phone" value="{{ old('booth_phone') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('booth_phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="vat_no" class="block text-sm font-medium text-gray-700 mb-1">VAT Registration
                    No</label>
                <input type="text" name="vat_no" id="vat_no" value="{{ old('vat_no') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('vat_no')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">Booth Currency</label>
                <input type="text" name="currency" id="currency" value="{{ old('currency') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('currency')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="master_booth" class="block text-sm font-medium text-gray-700 mb-1">Master Booth</label>
                <select name="master_booth" id="master_booth"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">--Select Master Booth--</option>
                    <option value="0">Sub Booth</option>
                    <option value="1">Master Booth</option>
                    <option value="3">Sub Booth With Real IP</option>
                </select>
                @error('master_booth')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="parent_booth" class="block text-sm font-medium text-gray-700 mb-1">Parent Booth</label>
                <select name="parent_booth" id="parent_booth"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">--Select Parent Booth--</option>
                    @foreach ($booths as $booth)
                    <option value="{{ $booth->booth_id }}">{{ $booth->booth_name }}</option>
                    @endforeach
                </select>
                @error('parent_booth')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="booth_ip" class="block text-sm font-medium text-gray-700 mb-1">Booth IP</label>
                <input type="text" name="booth_ip" id="booth_ip" value="{{ old('booth_ip') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('booth_ip')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="booth_lan_ip" class="block text-sm font-medium text-gray-700 mb-1">Booth LAN
                    IP</label>
                <input type="text" name="booth_lan_ip" id="booth_lan_ip" value="{{ old('booth_lan_ip') }}"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('booth_lan_ip')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="server_connection_status" class="block text-sm font-medium text-gray-700 mb-1">Server
                    Connection Status</label>
                <select name="server_connection_status" id="server_connection_status"
                    class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="0">Connected through Internet</option>
                    <option value="1">Connected through LAN</option>
                </select>
                @error('server_connection_status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center space-x-3">
                <label for="booth_online_booking" class="text-sm font-medium text-gray-700">Online Booking</label>
                <input type="checkbox" name="booth_online_booking" id="booth_online_booking"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <p class="text-red-500 text-xs mt-1">Please check, if online booking available</p>
                @error('booth_online_booking')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center space-x-3">
                <label for="booth_pocket_counter" class="text-sm font-medium text-gray-700">Pocket Counter</label>
                <input type="checkbox" name="booth_pocket_counter" id="booth_pocket_counter"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <p class="text-red-500 text-xs mt-1">Please check, if this booth also act as pocket counter.</p>
                @error('booth_pocket_counter')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="mt-6 text-right">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">Save
            </button>
        </div>
</form>