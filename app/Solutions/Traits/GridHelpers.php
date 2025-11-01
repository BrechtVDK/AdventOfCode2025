<?php

namespace App\Solutions\Traits;

trait GridHelpers
{
    protected function parseGrid(): array
    {
        return array_map('str_split', $this->getLines());
    }

    protected function findInGrid(array $grid, string $char): ?array
    {
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell === $char) {
                    return [$x, $y];
                }
            }
        }
        return null;
    }

    protected function getNeighbors(int $x, int $y, bool $includeDiagonal = false): array
    {
        $directions = [[-1, 0], [1, 0], [0, -1], [0, 1]];
        
        if ($includeDiagonal) {
            $directions = array_merge($directions, [[-1, -1], [-1, 1], [1, -1], [1, 1]]);
        }

        return array_map(fn($d) => [$x + $d[0], $y + $d[1]], $directions);
    }

    protected function isValidPosition(array $grid, int $x, int $y): bool
    {
        return isset($grid[$y][$x]);
    }

    protected function printGrid(array $grid): void
    {
        foreach ($grid as $row) {
            echo implode('', $row) . PHP_EOL;
        }
    }
}
