@include('pages.partials.functional-location-show-page', [
    'title' => 'Customer Functional Location',
    'description' => $emptyState
        ? 'Empty customer functional location workspace until a record is selected from search.'
        : 'Detail workspace for the selected aircraft record, adapted into the current ATP design system.',
    'emptyState' => $emptyState,
    'recordId' => $recordId,
    'record' => $record,
])
