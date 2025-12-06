<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_04 extends AbstractSolution
{
    private const string ROLL_OF_PAPER = '@';
    private const string REMOVED = 'x';

    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 04, $useExample);
    }

    protected function parseInput(): array
    {
        // Parse and return structured data from $this->input
        return get_grid($this->input);
    }

    public function silver(): int|string
    {
        $grid = $this->parsedInput;
        $maxRow = count($grid) - 1;
        $maxCol = count($grid[0]) - 1;
        $accessibleRols = 0;
        for ($row = 0; $row < count($grid); $row++) {
            for ($col = 0; $col < count($grid[0]); $col++) {
                if ($grid[$row][$col] !== self::ROLL_OF_PAPER) continue;
                $rollsOfPaper = 0;
                foreach (neighbors_8($row, $col, $maxRow, $maxCol) as $neighbor) {
                    if ($grid[$neighbor[0]][$neighbor[1]] === self::ROLL_OF_PAPER) {
                        $rollsOfPaper++;
                    }
                };
                if ($rollsOfPaper < 4) {
                    $accessibleRols++;
                }
            }

        }
        return $accessibleRols;
    }

    public function gold(): int|string
    {

        $grid = $this->parsedInput;
        $maxRow = count($grid) - 1;
        $maxCol = count($grid[0]) - 1;
        $removedCount = 0;
        do {
            $removed = false;
            for ($row = 0; $row < count($grid); $row++) {
                for ($col = 0; $col < count($grid[0]); $col++) {
                    if ($grid[$row][$col] !== self::ROLL_OF_PAPER) continue;
                    $rollsOfPaper = 0;
                    foreach (neighbors_8($row, $col, $maxRow, $maxCol) as $neighbor) {
                        if ($grid[$neighbor[0]][$neighbor[1]] === self::ROLL_OF_PAPER) {
                            $rollsOfPaper++;
                        }
                    };
                    if ($rollsOfPaper < 4) {
                        $grid[$row][$col] = self::REMOVED;
                        $removedCount++;
                        $removed = true;
                    }
                }
            }
        } while ($removed);
        return $removedCount;
    }

}
