# Livewire Manual Verification

Use this checklist whenever a new Livewire page or component is added.

## Baseline

- [ ] Page loads without JavaScript console errors
- [ ] Livewire requests complete successfully
- [ ] Styles look correct after the component hydrates
- [ ] Alpine-driven UI still works alongside the Livewire component
- [ ] Flowbite elements still work after Livewire updates or navigation

## Tables

- [ ] Search updates results correctly
- [ ] Filters update results correctly
- [ ] Pagination works
- [ ] Sorting works
- [ ] Empty states render correctly
- [ ] Loading states are acceptable

## Forms

- [ ] Validation messages appear correctly
- [ ] Error state styles render correctly
- [ ] Save/update actions work without layout glitches
- [ ] Disabled/loading submit states feel clear
- [ ] Success/error feedback is visible

## Modals And Actions

- [ ] Modal opens/closes correctly
- [ ] Modal state resets when expected
- [ ] Server-backed actions complete without stale UI
- [ ] Confirmation/destructive actions are clear

## URL And Navigation

- [ ] Query string state behaves correctly if used
- [ ] Browser back/forward behavior is acceptable
- [ ] Page refresh preserves intended state

## Regression Check

- [ ] Shared Blade components still render correctly
- [ ] Existing Alpine tabs/dropdowns still work
- [ ] No duplicated controls appear after rerender
- [ ] No Livewire/Alpine ownership conflicts are visible
