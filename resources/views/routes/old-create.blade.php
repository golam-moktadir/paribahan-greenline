@extends('layouts.app')

@section('title', 'Add New Route')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.css') }}">
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
            <form method="POST" action="{{ route($resource . '.store') }}" enctype="multipart/form-data"
                class="max-w-2xl w-full p-6 bg-white shadow-md rounded-lg space-y-4">
                @csrf







             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="w-full">
                        <label for="route_name" class="block text-sm font-medium text-gray-700 mb-1">Route <span class="text-red-500">*</span></label>
                        <input type="text" name="route_name" id="route_name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" readonly>
                        @error('route_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-wrap items-end gap-2">
                        <select name="city_id" id="city_id"
                            class="w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" id="route-add-button" class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">Add</button>
                        <button type="button" id="route-clear-button" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 text-sm">Clear</button>
                    </div>
                </div> 
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="w-full">
                        <label for="return_route" class="block text-sm font-medium text-gray-700 mb-1">Return Route </label>
                        <input type="text" name="return_route" id="return_route" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" readonly>
                    </div>
                    <div class="flex flex-wrap items-end gap-2">
                        <select name="return_city_id" id="return_city_id" class="w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" disabled>
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" id="return-add-button" class="px-3 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 opacity-50 cursor-not-allowed" disabled>Add</button>
                        <button type="button" id="return-clear-button" class="px-3 py-2 bg-red-500 text-white rounded-md text-sm opacity-50 cursor-not-allowed" disabled>Clear</button>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="check_same_route" id="check_same_route" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                    <label for="check_same_route" class="text-sm text-gray-700"> Keep checked if return route is same as route.</label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="w-full">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full max-w-2xl px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm resize-none"></textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="w-full">
                        <label for="route_total_bus" class="block text-sm font-medium text-gray-700 mb-1">Total Bus <span class="text-red-500"></span></label>
                        <input type="text" name="route_total_bus" id="route_total_bus" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('route_total_bus')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <label for="route_online_booking_option" class="text-sm font-medium text-gray-700">Online Booking</label>
                    <input type="checkbox" name="route_online_booking_option" id="route_online_booking_option"
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="1">
                    <p class="text-red-500 text-xs mt-1">Please check, if online booking available</p>
                    @error('route_online_booking_option')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>                
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                        Save
                    </button>
                    <a href="{{ route($resource . '.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery-3-7-1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.js') }}" defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // let city_id = [];
            // let city_name = [];
            // $("#route-add-button").click(function () {
            //     $('#city_id').each(function () {
            //         if (city_id.includes($(this).val()) == false) {
            //             if($(this).val() != ""){
            //                 city_id.push($(this).val());
            //                 city_name.push($(this).find('option:selected').text());
            //                 $("#route_name").val(city_name.join(" - "));
            //                 $("#return_route").val(city_name.reverse().join(" - "));
            //                 $('#route_name').focus();
            //                 $("#city_id").val("");
            //             }
            //         }
            //         else {
            //             Swal.fire("Already Taken this City!");
            //         }
            //     });
            //     console.log(city_id);
            // });

            let return_city_id = [];
            let return_city_name = [];
            $("#return-add-button").click(function () {
                $('#return_city_id').each(function () {
                    if (return_city_id.includes($(this).val()) == false) {
                        if($(this).val() != ""){
                            return_city_id.push($(this).val());
                            return_city_name.push($(this).find('option:selected').text());
                            $("#return_route").val(return_city_name.join(" - "));
                            $('#return_route').focus();
                            $("#return_city_id").val("");
                        }
                    }
                    else {
                        Swal.fire("Already Taken this City!");
                    }
                });
            });

            $("#route-clear-button").click(function () {
                $("#route_name").val("");
                $("#return_route").val("");
                $("#city_id").val("");
            });

            $("#return-clear-button").click(function () {
                $("#return_route").val("");
                $("#return_city_id").val("");
            });

            $("#check_same_route").click(function (){
                if($(this).is(':checked') == false){
                    $('#return-add-button, #return-clear-button, #return_city_id').prop('disabled', false)
                      .removeClass('opacity-50 cursor-not-allowed');
                    $("#return_route").val("");
                }
                else{
                    $('#return-add-button, #return-clear-button, #return_city_id').prop('disabled', true)
                      .addClass('opacity-50 cursor-not-allowed');
                    $("#return_route").val(city_name.reverse().join(" - "));
                } 
            });
        });
    </script>




  
@endpush