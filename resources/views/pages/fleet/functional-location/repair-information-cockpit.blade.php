@extends('layouts.app')

@section('title', 'Repair Information Cockpit')

@section('content')
    @include('pages.partials.show-page',         array (
          'title' => 'Repair Information Cockpit',
          'description' => 'Tabbed cockpit layout covering repair creation, activity, detail, and work-order context.',
          'tabs' => 
          array (
            0 => 
            array (
              'id' => 'create',
              'label' => 'Create',
              'items' => 
              array (
                0 => 
                array (
                  'label' => 'Template',
                  'value' => 'Repair request',
                ),
                1 => 
                array (
                  'label' => 'Prepared by',
                  'value' => 'Structures Team',
                ),
              ),
            ),
            1 => 
            array (
              'id' => 'activity',
              'label' => 'Activity',
              'items' => 
              array (
                0 => 
                array (
                  'label' => 'Current status',
                  'value' => 'Waiting for material review',
                ),
                1 => 
                array (
                  'label' => 'Last update',
                  'value' => 'Today 09:45',
                ),
              ),
            ),
            2 => 
            array (
              'id' => 'detail',
              'label' => 'Detail',
              'items' => 
              array (
                0 => 
                array (
                  'label' => 'Reference',
                  'value' => 'RPR-4103',
                ),
                1 => 
                array (
                  'label' => 'Station',
                  'value' => 'Kuala Lumpur',
                ),
              ),
            ),
            3 => 
            array (
              'id' => 'work-order',
              'label' => 'Work Order',
              'items' => 
              array (
                0 => 
                array (
                  'label' => 'WO Link',
                  'value' => 'WO-91022',
                ),
                1 => 
                array (
                  'label' => 'Assigned',
                  'value' => 'Composite Shop',
                ),
              ),
            ),
          ),
        ))

@endsection

