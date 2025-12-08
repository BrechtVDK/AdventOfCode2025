<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_07 extends AbstractSolution
{
    private array $startingPointsDone = [];
    private array $startingPointsToDoStack = [];
    private array $grid = [];
    private const string SPLITTER = '^';
    private const string BEAM = '|';

    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 07, $useExample);
        $this->grid = $this->parsedInput;
    }

    protected function parseInput(): array
    {
        // Parse and return structured data from $this->input
        return get_grid($this->input);
    }

    public function silver(): int|string
    {
        for ($row = 0; $row < count($this->grid); $row++) {
            for ($col = 0; $col < count($this->grid[$row]); $col++) {
                if ($this->grid[$row][$col] === '.') {
                    $this->grid[$row][$col] = 0;
                }
            }
        }
        $startPoint = [0, array_search('S', $this->grid[0])];
        $this->grid[0][$startPoint[1]] = 1;

        $this->beam();
        return $this->countSplits();

    }

    public function gold(): int|string
    {

        return array_sum($this->grid[count($this->grid) - 1]);

    }

    private function beam(): void
    {
        for ($row = 1; $row < count($this->grid); $row++) {
            for ($col = 0; $col < count($this->grid[$row]); $col++) {
                if ($this->grid[$row][$col] === self::SPLITTER) {
                    $this->grid[$row][$col - 1] += $this->grid[$row - 1][$col];
                    $this->grid[$row][$col + 1] += $this->grid[$row - 1][$col];
                } elseif ($this->grid[$row - 1][$col] !== self::SPLITTER) {
                    $this->grid[$row][$col] += $this->grid[$row - 1][$col];
                }
            }
        }


    }

    private function countSplits(): int
    {
        $splits = 0;
        for ($row = 0; $row < count($this->grid); $row++) {
            for ($col = 0; $col < count($this->grid[$row]); $col++) {
                if ($this->grid[$row][$col] === self::SPLITTER && $this->grid[$row][$col - 1] > 0 && $this->grid[$row][$col + 1] > 0 && $this->grid[$row - 1][$col] > 0) {
                    $splits++;
                }
            }
        }
        return $splits;
    }
}
