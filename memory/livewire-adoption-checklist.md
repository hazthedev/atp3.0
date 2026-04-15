# Livewire Adoption Checklist

This file tracks which ATP modules should move to `Livewire` based on the current project rule:

- Use `Livewire` for server-driven CRUD, filters, searches, validated forms, modal workflows, and attach/detach/apply/remove actions.
- Keep `Blade + Alpine` for static pages, read-heavy detail views, and pages that do not yet have real backend behavior.

## Status

- `[ ]` Not started
- `[x]` Completed

## Foundation

- [x] Install `livewire/livewire`
- [x] Add Livewire scripts and styles to the shared application layout
- [x] Establish ATP Livewire conventions for tables, filters, modals, validation, and Alpine interop
- [x] Create a base checklist for manual verification of Livewire components

## Wave 1

- [ ] CRM: `Business Partner`
- [x] Fleet > Functional Location: `Search Functional Locations`
- [x] Fleet > Functional Location: `Customer Functional Location`
- [x] Fleet > Functional Location: `Attach equipment to functional location`
- [x] Fleet > Functional Location: `Detach equipment from functional location`
- [x] Fleet > Functional Location: `Change customer information`
- [x] Fleet > Functional Location: `Pending Installed Base updates from Work Orders`
- [x] Fleet > Equipment: `Equipment` list
- [x] Fleet > Equipment: `Components Monitoring`
- [x] Fleet > Equipment: `Customer Equipment Card`
- [x] Fleet > Equipment: `Attach Equipment`
- [x] Fleet > Equipment: `Detach Equipment`
- [x] Fleet > Equipment: `Swap Equipment`
- [x] Fleet > Equipment: `Change customer information`
- [x] Fleet > Equipment: `Generate Equipment Card`
- [x] Fleet > Equipment: `Pending Install Base Update`
- [x] Fleet > Equipment: `Maintenance Item Monitoring`
- [x] Fleet > Minimum Equipment List: `Minimum Equipment List`
- [x] Fleet > Modification: `Search Modifications`
- [x] Fleet > Modification: `Apply Modifications to an Equipment`
- [x] Fleet > Modification: `Apply Modifications to a Functional Location`
- [x] Fleet > Modification: `Equipment Reference Evolution`
- [x] Fleet > Maintenance Program: `Maintenance Program`
- [ ] Fleet > Modification: remaining remove/effectivity workflows

## Wave 2

- [ ] Fleet > Technical Logs
- [ ] Fleet > Counter
- [ ] Maintenance > Maintenance Program
- [x] Maintenance > Maintenance Plan Administration
- [ ] Maintenance > Maintenance Plan
- [x] Maintenance > Work Package
- [x] Maintenance > Apply Visit
- [x] Maintenance > Apply Task List
- [x] Maintenance > Simulation on Fleet
- [ ] Services: all list/create modules
- [ ] Search: all search result modules

## Wave 3

- [x] Fleet Report > `Historical Equipment Hierarchy`
- [x] Fleet Report > `View Modification On Equipment`
- [ ] System > User Management
- [ ] System > Item Master Data
- [ ] System > Business Partner Master Data
- [ ] System > Technical Logs
- [ ] System > Aircraft Type
- [ ] System > Functional Location
- [ ] System > Counter
- [ ] System > Manage Status
- [ ] Initialization > Apply Maintenance Program
- [ ] Initialization > Structure Duplication

## Keep Blade + Alpine For Now

- Dashboard
- Fleet / Operations cockpit-style summary pages until they become data-heavy workflows
- Reports pages until they require rich filtering, drilldowns, or interactive analytics
- Lookups landing pages

## Inertia Only If Needed Later

- Flight Schedule if it becomes a rich scheduling board
- Fleet Management Cockpit if it becomes a highly interactive planner
- Operations cockpit pages if they evolve into dense real-time workspaces
- Advanced report dashboards with heavy client-side state
