@extends('layoutdashboard')

@section('title','Dashboard')

@section('content')
<div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-4 shadow-md rounded-md">
                    <h2 class="text-xl font-bold mb-2">Total de cours</h2>
                    <p class="text-3xl">3</p>
                </div>
                <div class="bg-white p-4 shadow-md rounded-md">
                    <h2 class="text-xl font-bold mb-2">Total de classes</h2>
                    <p class="text-3xl">4</p>
                </div>
</div>
@endsection
