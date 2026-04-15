<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use App\Support\ModificationCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class ApplyModificationOnFunctionalLocationPage extends Component
{
    public ?string $functionalLocationId = null;

    /** @var array<string, mixed> */
    public array $functionalLocation = [];

    public string $status = 'Applicable';

    public string $action = 'Apply';

    public string $dateForAction = '';

    public string $comment = '';

    /** @var array<int, array<string, string>> */
    public array $selectedModifications = [];

    public bool $functionalLocationModalOpen = false;

    public string $functionalLocationSearch = '';

    public ?string $pendingFunctionalLocationId = null;

    public bool $modificationModalOpen = false;

    public string $modificationSearch = '';

    public ?string $pendingModificationId = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->dateForAction = now()->format('d.m.y');

        $functionalLocationId = request()->query('functional_location_id');
        $record = FunctionalLocationCatalog::find($functionalLocationId);

        if ($record !== null) {
            $this->functionalLocationId = (string) $record['id'];
            $this->functionalLocation = $record;
        }
    }

    public function openFunctionalLocationModal(): void
    {
        $this->functionalLocationModalOpen = true;
        $this->functionalLocationSearch = '';
        $this->pendingFunctionalLocationId = $this->functionalLocationId;
    }

    public function closeFunctionalLocationModal(): void
    {
        $this->functionalLocationModalOpen = false;
        $this->functionalLocationSearch = '';
        $this->pendingFunctionalLocationId = null;
    }

    public function selectFunctionalLocationResult(string $functionalLocationId): void
    {
        $this->pendingFunctionalLocationId = $functionalLocationId;
    }

    public function chooseFunctionalLocationResult(): void
    {
        if ($this->pendingFunctionalLocationId === null) {
            $this->setStatus('Select a functional location row first.', 'amber');

            return;
        }

        $record = FunctionalLocationCatalog::find($this->pendingFunctionalLocationId);

        if ($record === null) {
            $this->setStatus('The selected functional location record could not be found.', 'red');

            return;
        }

        $this->functionalLocationId = (string) $record['id'];
        $this->functionalLocation = $record;
        $this->closeFunctionalLocationModal();
        $this->setStatus('Loaded functional location ' . $record['code'] . ' into the workspace.', 'blue');
    }

    public function openModificationModal(): void
    {
        $this->modificationModalOpen = true;
        $this->modificationSearch = '';
        $this->pendingModificationId = null;
    }

    public function closeModificationModal(): void
    {
        $this->modificationModalOpen = false;
        $this->modificationSearch = '';
        $this->pendingModificationId = null;
    }

    public function selectModificationResult(string $modificationId): void
    {
        $this->pendingModificationId = $modificationId;
    }

    public function chooseModificationResult(): void
    {
        if ($this->pendingModificationId === null) {
            $this->setStatus('Select a modification row first.', 'amber');

            return;
        }

        $record = ModificationCatalog::find($this->pendingModificationId);

        if ($record === null) {
            $this->setStatus('The selected modification record could not be found.', 'red');

            return;
        }

        $exists = collect($this->selectedModifications)
            ->contains(static fn (array $row): bool => $row['id'] === $record['id']);

        if (! $exists) {
            $this->selectedModifications[] = $record;
            $this->setStatus('Added modification ' . $record['unique_ref'] . ' to the staged list.', 'blue');
        } else {
            $this->setStatus('Modification ' . $record['unique_ref'] . ' is already in the staged list.', 'amber');
        }

        $this->closeModificationModal();
    }

    public function clearModifications(): void
    {
        $this->selectedModifications = [];
        $this->setStatus('Cleared the staged modification list.', 'blue');
    }

    public function initializePreview(): void
    {
        if ($this->functionalLocationId === null) {
            $this->setStatus('Choose a functional location before initializing the action.', 'amber');

            return;
        }

        if (count($this->selectedModifications) === 0) {
            $this->setStatus('Add at least one modification before initializing the action.', 'amber');

            return;
        }

        $this->setStatus(
            sprintf(
                'Initialized %s action for functional location %s with %d staged modification%s.',
                strtolower($this->action),
                $this->functionalLocation['code'] ?? $this->functionalLocationId,
                count($this->selectedModifications),
                count($this->selectedModifications) === 1 ? '' : 's',
            ),
            'green',
        );
    }

    public function submitPreview(): void
    {
        if ($this->functionalLocationId === null) {
            $this->setStatus('Choose a functional location before completing the workflow.', 'amber');

            return;
        }

        $this->setStatus(
            sprintf(
                'Apply modification preview saved for functional location %s with %d staged modification%s.',
                $this->functionalLocation['code'] ?? $this->functionalLocationId,
                count($this->selectedModifications),
                count($this->selectedModifications) === 1 ? '' : 's',
            ),
            'green',
        );
    }

    public function cancelPreview(): void
    {
        $this->reset([
            'functionalLocationId',
            'functionalLocation',
            'comment',
            'selectedModifications',
            'functionalLocationModalOpen',
            'functionalLocationSearch',
            'pendingFunctionalLocationId',
            'modificationModalOpen',
            'modificationSearch',
            'pendingModificationId',
            'statusMessage',
        ]);

        $this->status = 'Applicable';
        $this->action = 'Apply';
        $this->statusTone = 'blue';
        $this->dateForAction = now()->format('d.m.y');
    }

    public function render()
    {
        return view('livewire.fleet.apply-modification-on-functional-location-page', [
            'functionalLocationSearchResults' => FunctionalLocationCatalog::search($this->functionalLocationSearch),
            'selectedFunctionalLocationSearchRecord' => $this->pendingFunctionalLocationId !== null
                ? FunctionalLocationCatalog::find($this->pendingFunctionalLocationId)
                : null,
            'modificationSearchResults' => $this->filteredModifications($this->modificationSearch),
            'selectedModificationSearchRecord' => $this->pendingModificationId !== null
                ? ModificationCatalog::find($this->pendingModificationId)
                : null,
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    private function filteredModifications(string $search): Collection
    {
        $needle = mb_strtolower(trim($search));

        if ($needle === '') {
            return ModificationCatalog::all()->values();
        }

        return ModificationCatalog::all()
            ->filter(function (array $row) use ($needle): bool {
                $haystack = implode(' ', [
                    $row['type'],
                    $row['unique_ref'],
                    $row['reference'],
                    $row['revision'],
                    $row['title'],
                ]);

                return mb_stripos($haystack, $needle) !== false;
            })
            ->values();
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
