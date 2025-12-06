<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;
use PhpCollection\Set;

class Solution_05 extends AbstractSolution
{
    private array $ranges;
    private array $ids;

    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 05, $useExample);

        $this->ranges = array_map(function ($range) {
            return explode('-', $range);
        }, get_lines($this->parsedInput[0]));

        $this->ids = get_lines($this->parsedInput[1]);
    }

    protected function parseInput(): array
    {
        return $this->getBlocks();

    }

    public function silver(): int|string
    {
        $freshIds = 0;
        foreach ($this->ids as $id) {
            if ($this->isFresh($id)) {
                $freshIds++;
            }
        }
        return $freshIds;
    }

    public function gold(): int|string
    {/* works for example input, not for real input
        $set = new Set();
        foreach ($this->ranges as $range) {
            foreach (range($range[0], $range[1]) as $id) {
                $set->add($id);
            }
        }
        return $set->count();*/
        usort($this->ranges, fn($a, $b) => $a[0] <=> $b[0]);

        $merged = [];
        $current = $this->ranges[0];

        foreach ($this->ranges as $range) {
            if ($range[0] <= $current[1] + 1) {
                $current[1] = max($current[1], $range[1]);
            } else {
                $merged[] = $current;
                $current = $range;
            }
        }
        $merged[] = $current;

        $count = 0;
        foreach ($merged as $range) {
            $count += $range[1] - $range[0] + 1;
        }

        return $count;
    }

    private function isFresh(int $id): bool
    {
        return array_any($this->ranges, fn($range) => $this->isInRange($id, $range));

    }

    private function isInRange(int $id, array $range): bool
    {
        return $id >= $range[0] && $id <= $range[1];
    }
}
