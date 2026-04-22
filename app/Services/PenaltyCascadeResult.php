<?php

declare(strict_types=1);

namespace App\Services;

class PenaltyCascadeResult
{
    /** @var array<int, int> */
    public array $rulesFired = [];

    /** @var array<int, array{type: string, id: int}> */
    public array $affectedTargets = [];

    public int $historyRowsWritten = 0;

    public int $maxDepthReached = 0;

    public bool $depthLimitHit = false;

    /** @var array<int, string> */
    public array $warnings = [];

    public function summary(): string
    {
        $parts = [
            count($this->rulesFired) . ' rule' . (count($this->rulesFired) === 1 ? '' : 's') . ' fired',
        ];

        $distinctTargets = count(array_unique(array_map(
            fn (array $t): string => $t['type'] . ':' . $t['id'],
            $this->affectedTargets,
        )));

        $parts[] = $distinctTargets . ' target' . ($distinctTargets === 1 ? '' : 's');
        $parts[] = $this->historyRowsWritten . ' history row' . ($this->historyRowsWritten === 1 ? '' : 's');

        if ($this->depthLimitHit) {
            $parts[] = 'depth limit hit';
        }

        return implode(', ', $parts);
    }
}
