@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md border-t-4 border-orange-500">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Trip Details</h2>
            <p class="text-gray-400">Our form inputs will go here next!</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-gray-800">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Summary</h2>
            <p class="text-gray-400">Our earnings calculation will go here!</p>
        </div>

    </div>
@endsection