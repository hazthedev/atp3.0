@include('pages.partials.customer-equipment-card-page', [
    'title' => 'Customer Equipment Card',
    'description' => $emptyState
        ? 'Empty customer equipment card workspace until a record is selected from search.'
        : 'Detail workspace for the selected equipment record, adapted into the current ATP design system.',
    'emptyState' => $emptyState,
    'recordId' => $recordId,
    'record' => $record,
])
