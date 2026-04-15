@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'User Management',
          'description' => 'Static placeholder list view for the User Management module.',
          'createRoute' => 'system.user-management.create',
          'columns' => 
          array (
            0 => 'User',
            1 => 'Role',
            2 => 'Team',
            3 => 'Status',
            4 => 'Last Login',
          ),
        ))

@endsection

