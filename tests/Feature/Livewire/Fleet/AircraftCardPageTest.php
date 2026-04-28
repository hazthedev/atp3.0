<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Fleet;

use App\Livewire\Fleet\AircraftCardPage;
use App\Support\AircraftCardCatalog;
use Livewire\Livewire;
use Tests\TestCase;

class AircraftCardPageTest extends TestCase
{
    public function test_mount_with_no_param_uses_default_registration(): void
    {
        Livewire::test(AircraftCardPage::class)
            ->assertSet('registration', AircraftCardCatalog::default())
            ->assertSet('activeTab', 'overview')
            ->assertSet('editMode', false);
    }

    public function test_mount_with_known_registration_param_hydrates_aircraft(): void
    {
        Livewire::test(AircraftCardPage::class, ['registration' => 'A6-EAS'])
            ->assertSet('registration', 'A6-EAS');
    }

    public function test_mount_with_unknown_registration_falls_back_to_default(): void
    {
        Livewire::test(AircraftCardPage::class, ['registration' => 'BOGUS'])
            ->assertSet('registration', AircraftCardCatalog::default());
    }

    public function test_switch_aircraft_updates_registration_and_resets_edit_mode(): void
    {
        Livewire::test(AircraftCardPage::class)
            ->call('enableEdit')
            ->assertSet('editMode', true)
            ->call('switchAircraft', 'A6-WSA')
            ->assertSet('registration', 'A6-WSA')
            ->assertSet('editMode', false);
    }

    public function test_switch_aircraft_ignores_unknown_registration(): void
    {
        Livewire::test(AircraftCardPage::class)
            ->call('switchAircraft', 'BOGUS')
            ->assertSet('registration', AircraftCardCatalog::default());
    }

    public function test_set_tab_updates_active_tab(): void
    {
        Livewire::test(AircraftCardPage::class)
            ->call('setTab', 'general')
            ->assertSet('activeTab', 'general')
            ->call('setTab', 'events')
            ->assertSet('activeTab', 'events');
    }

    public function test_set_tab_ignores_unknown_tab(): void
    {
        Livewire::test(AircraftCardPage::class)
            ->call('setTab', 'bogus')
            ->assertSet('activeTab', 'overview');
    }

    public function test_all_tabs_render_without_error(): void
    {
        $tabs = array_keys(AircraftCardPage::TABS);

        foreach ($tabs as $tab) {
            Livewire::test(AircraftCardPage::class)
                ->call('setTab', $tab)
                ->assertSet('activeTab', $tab)
                ->assertOk();
        }
    }

    public function test_edit_cycle_enables_then_cancels_restores_form(): void
    {
        $component = Livewire::test(AircraftCardPage::class)
            ->call('enableEdit')
            ->assertSet('editMode', true)
            ->set('form.lifecycle.acquisition_cost', '99,999,999.00')
            ->call('cancelEdit')
            ->assertSet('editMode', false);

        $this->assertSame('45,600,000.00', $component->get('form.lifecycle.acquisition_cost'));
    }

    public function test_save_exits_edit_mode_and_dispatches_event(): void
    {
        Livewire::test(AircraftCardPage::class)
            ->call('enableEdit')
            ->assertSet('editMode', true)
            ->call('save')
            ->assertSet('editMode', false)
            ->assertDispatched('aircraft-card-saved');
    }

    public function test_route_returns_200_for_default(): void
    {
        $this->get(route('fleet.functional-location.aircraft-card'))
            ->assertOk()
            ->assertSee('Aircraft Card');
    }

    public function test_route_returns_200_for_each_aircraft(): void
    {
        foreach (AircraftCardCatalog::all() as $ac) {
            $this->get(route('fleet.functional-location.aircraft-card.show', ['registration' => $ac['registration']]))
                ->assertOk()
                ->assertSee($ac['registration']);
        }
    }
}
