@extends('layouts.app')

@section('title', 'Modification')

@section('content')
    @php
        use App\Support\ModificationCatalog;

        $record = ModificationCatalog::find((int) request()->route('id'));
    @endphp
    @include('pages.partials.modification-show-page', ['record' => $record])
@endsection

