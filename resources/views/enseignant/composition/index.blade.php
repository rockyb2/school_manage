@extends('layoutdashboard')

@section('title', 'Fiche de note')
@section('content')
<div class="flex items-center justify-center">
    <button class="rounded-xl p-2 bg-fuchsia-300"><a href=" {{ route('composition.store') }}">Créer une composition</a></button>
</div>
@endsection
