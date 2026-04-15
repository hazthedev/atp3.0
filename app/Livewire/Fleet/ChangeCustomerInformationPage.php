<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use Livewire\Component;

class ChangeCustomerInformationPage extends Component
{
    public string $functionalLocationCode = '';

    public bool $recordLoaded = false;

    public string $serialNo = '';

    public string $registration = '';

    public string $type = '';

    public string $ownerCode = '';

    public string $ownerName = '';

    public string $operatorCode = '';

    public string $operatorName = '';

    public bool $forceOwnerPropagation = true;

    public string $dateOfChange = '30.03.26';

    public string $comment = '';

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->hydrateFunctionalLocation(false);
    }

    public function updatedFunctionalLocationCode(): void
    {
        $this->hydrateFunctionalLocation(true);
    }

    public function loadFunctionalLocation(): void
    {
        $this->hydrateFunctionalLocation(true);
    }

    public function confirmPreview(): void
    {
        $code = trim($this->functionalLocationCode) !== '' ? $this->functionalLocationCode : 'selected functional location';
        $this->setStatus(sprintf('Customer information preview confirmed for %s.', $code), 'green');
    }

    public function render()
    {
        return view('livewire.fleet.change-customer-information-page');
    }

    private function hydrateFunctionalLocation(bool $announce): void
    {
        $code = strtoupper(trim($this->functionalLocationCode));
        $record = FunctionalLocationCatalog::all()->firstWhere('code', $code);

        if ($record === null) {
            $this->recordLoaded = false;
            $this->serialNo = '';
            $this->registration = '';
            $this->type = '';
            $this->ownerCode = '';
            $this->ownerName = '';
            $this->operatorCode = '';
            $this->operatorName = '';

            if ($announce) {
                $this->setStatus('No functional location matched that ID. Try 9M-WAA, 9M-WAB, or 9M-WAV.', 'amber');
            }

            return;
        }

        $this->recordLoaded = true;
        $this->functionalLocationCode = $record['code'];
        $this->serialNo = $record['serial_no'];
        $this->registration = $record['registration'];
        $this->type = $record['type'];
        $this->ownerCode = $record['owner_code'];
        $this->ownerName = $record['owner_name'];
        $this->operatorCode = $record['operator_code'];
        $this->operatorName = $record['operator_name'];

        if ($announce) {
            $this->setStatus(sprintf('Loaded customer information for %s.', $record['code']), 'blue');
        }
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
