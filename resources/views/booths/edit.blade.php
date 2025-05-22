
@extends('layouts.app')

@section('title', 'Edit Booth')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}">
@endpush

@section('content')
    <div class="form-container">
        <div class="card">
            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('booths.update',  $booth->booth_id) }}" enctype="multipart/form-data"
                class="max-w-lg w-full p-6 bg-white shadow-md rounded-lg space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4 text-left">
                    <input type="hidden" name="booth_saved_by" value="1">
                    <input type="hidden" name="transport_id" value="1">
                    <div>
                        <label for="booth_name" class="block text-sm font-medium text-gray-700 mb-1">Booth Name <span
                                    class="text-red-500">*</span></label>
                        <input type="text" name="booth_name" id="booth_name" value="{{ $booth->booth_name }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" required>
                        @error('booth_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="booth_code" class="block text-sm font-medium text-gray-700 mb-1">Booth Code <span class="text-red-500">*</span></label>
                        <input type="text" name="booth_code" id="booth_code" value="{{ $booth->booth_code }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" required maxlength="4" readonly>
                        @error('booth_code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <select name="city_id" id="city_id" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->city_id }}" {{ $booth->station->city_id == $city->city_id ? 'selected' : ''}}>{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="station_id" class="block text-sm font-medium text-gray-700 mb-1">Station</label>
                        <select name="station_id" id="station_id" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">--Select Station--</option>
                            <option value="{{$booth->station_id}}" {{ $booth->station_id ? 'selected' : ''}}>{{$booth->station->station_name}}</option>
                        </select>
                    </div>
                    <div>
                        <label for="booth_man_in_charge_employee_id" class="block text-sm font-medium text-gray-700 mb-1">Man in Charge</label>
                        <select name="booth_man_in_charge_employee_id" id="booth_man_in_charge_employee_id" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">--Select Man In Charge--</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->employee_id }}" {{ $booth->booth_man_in_charge_employee_id == $employee->employee_id ? 'selected' : ''}}>{{ $employee->employee_name }}</option>
                            @endforeach
                        </select>
                        @error('booth_man_in_charge_employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="booth_address" class="block text-sm font-medium text-gray-700 mb-1">Booth Address</label>
                        <input type="text" name="booth_address" id="booth_address" value="{{ $booth->booth_address }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('booth_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="booth_phone" class="block text-sm font-medium text-gray-700 mb-1">Booth Phone</label>
                        <input type="text" name="booth_phone" id="booth_phone" value="{{ $booth->booth_phone }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="11">
                        @error('booth_phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="vat_no" class="block text-sm font-medium text-gray-700 mb-1">VAT Registration
                            No</label>
                        <input type="text" name="vat_no" id="vat_no" value="{{ $booth->vat_no }}"
                            class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('vat_no')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">Booth Currency</label>
                        <input type="text" name="currency" id="currency" value="{{ $booth->currency }}"
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
                            <option value="0" {{ $booth->master_booth == 0 ? 'selected' : '' }}>Sub Booth</option>
                            <option value="1" {{ $booth->master_booth == 1 ? 'selected' : '' }}>Master Booth</option>
                            <option value="3" {{ $booth->master_booth == 3 ? 'selected' : '' }}>Sub Booth With Real IP</option>
                        </select>
                        @error('master_booth')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="parent_booth" class="block text-sm font-medium text-gray-700 mb-1">Parent Booth</label>
                        <select name="parent_booth" id="parent_booth" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">--Select Parent Booth--</option>
                            @foreach ($booths as $row)
                            <option value="{{ $row->booth_id }}" {{ $booth->parent_booth == $row->booth_id ? 'selected' : '' }}>{{ $row->booth_name }}</option>
                            @endforeach
                        </select>
                        @error('parent_booth')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="booth_ip" class="block text-sm font-medium text-gray-700 mb-1">Booth IP</label>
                        <input type="text" name="booth_ip" id="booth_ip" value="{{ $booth->booth_ip }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('booth_ip')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="booth_lan_ip" class="block text-sm font-medium text-gray-700 mb-1">Booth LAN
                            IP</label>
                        <input type="text" name="booth_lan_ip" id="booth_lan_ip" value="{{ $booth->booth_lan_ip }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('booth_lan_ip')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="server_connection_status" class="block text-sm font-medium text-gray-700 mb-1">Server
                            Connection Status</label>
                        <select name="server_connection_status" id="server_connection_status"
                            class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="0" {{ $booth->server_connection_status == 0 ? 'selected' : '' }}>Connected through Internet</option>
                            <option value="1" {{ $booth->server_connection_status == 1 ? 'selected' : '' }}>Connected through LAN</option>
                        </select>
                        @error('server_connection_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center space-x-3">
                        <label for="booth_online_booking" class="text-sm font-medium text-gray-700">Online Booking</label>
                        <input type="checkbox" name="booth_online_booking" id="booth_online_booking" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="{{ $booth->booth_online_booking ?? 0 }}" {{ $booth->booth_online_booking == 1 ? 'checked' : '' }}>
                        <p class="text-red-500 text-xs mt-1">Please check, if online booking available</p>
                        @error('booth_online_booking')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center space-x-3">
                        <label for="booth_pocket_counter" class="text-sm font-medium text-gray-700">Pocket Counter</label>
                        <input type="checkbox" name="booth_pocket_counter" id="booth_pocket_counter"
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="{{ $booth->booth_pocket_counter ?? 0 }}" {{ $booth->booth_pocket_counter == 1 ? 'checked' : '' }}>
                        <p class="text-red-500 text-xs mt-1">Please check, if this booth also act as pocket counter.</p>
                        @error('booth_pocket_counter')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-6 text-right">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">Update
                    </button>
                    <a href="{{ route('booths.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery-3-7-1.min.js') }}"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            $("#city_id").on ('change', function(){
                let city_id = $(this).val();
                $.ajax({
                    url: "{{ route('booths.getStation') }}",
                    type: 'post',
                    data:{
                        city_id:city_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success:function(response){
                        $("#station_id").html(response);
                    }
                });
            });
        });
        
        
        // Initialize Flatpickr for datetime fields
        flatpickr('#upload_time, #download_time, #account_upload_time', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            time_24hr: true,
        });

        // Set current timestamp for employee_timestamp
        document.getElementById('employee_timestamp').value = new Date().toISOString().slice(0, 16);

        // Form validation for IP fields
        document.getElementById('boothForm').addEventListener('submit', (e) => {
            const ipFields = ['booth_ip', 'booth_lan_ip'];
            for (const field of ipFields) {
                const ip = document.getElementById(field).value;
                if (ip && ip !== '0.0.0.0') {
                    const ipRegex = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
                    if (!ipRegex.test(ip)) {
                        e.preventDefault();
                        alert(`Invalid IP address in ${field.replace('booth_', '').replace('_', ' ').toUpperCase()}`);
                        return;
                    }
                }
            }
        });
    </script>
@endpush
