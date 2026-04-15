@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    @include('pages.partials.list-page',         array (
          'title' => 'Tasks',
          'description' => 'Track personal and system-assigned tasks in a compact list layout.',
          'columns' => 
          array (
            0 => 'Task',
            1 => 'Owner',
            2 => 'Due',
            3 => 'Priority',
            4 => 'Status',
          ),
        ))

@endsection

