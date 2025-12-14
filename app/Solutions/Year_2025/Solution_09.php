<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_09 extends AbstractSolution
{
    private array $areasMap = [];
    private array $grid = [];

    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 9, $useExample);
    }

    protected function parseInput(): array
    {
        return array_map(function ($redTile) {
            return explode(',', $redTile);
        }, $this->getLines());
    }

    public function silver(): int|string
    {
        $maxArea = 0;
        $count = count($this->parsedInput);
        for ($i = 0; $i < $count - 1; $i++) {
            $red1 = $this->parsedInput[$i];
            for ($j = 0; $j < $count; $j++) {
                $red2 = $this->parsedInput[$j];
                $key = implode('.', $red1) . '-' . implode('.', $red2);
                $area = (abs($red2[0] - $red1[0]) + 1) * (abs($red2[1] - $red1[1]) + 1);

                $this->areasMap[$key] = $area;
                if ($area > $maxArea) {
                    $maxArea = $area;
                }

            }
        }

        return $maxArea;
    }

    public function gold(): int|string
    {
        // Solve part 2 using $this->parsedInput
        $this->makeGrid();
        $this->fillGrid();
        $this->printGrid();
        return 'todo';
    }

    // Add helper methods here
    private function makeGrid(): void
    {
        $cols = max(array_map(function ($redTile) {
            return $redTile[0];
        }, $this->parsedInput));

        $rows = max(array_map(function ($redTile) {
            return $redTile[1];
        }, $this->parsedInput));

        for ($row = 0; $row <= $rows; $row++) {
            for ($col = 0; $col <= $cols; $col++) {
                $this->grid[$row][$col] = '.';
            }
        }
        $count = count($this->parsedInput);
        for ($i = 0; $i < $count - 1; $i++) {
            $this->makeBorder($this->parsedInput[$i], $this->parsedInput[$i + 1]);
        }
        $this->makeBorder($this->parsedInput[0], $this->parsedInput[$count - 1]);

    }

    private function makeBorder(array $point1, array $point2): void
    {
        $col1 = $point1[0];
        $col2 = $point2[0];
        $row1 = $point1[1];
        $row2 = $point2[1];
        if ($col1 == $col2) {
            if ($row1 < $row2) {
                for ($i = $row1; $i <= $row2; $i++) {
                    $this->grid[$i][$col1] = '#';
                }
            } else {
                for ($i = $row2; $i <= $row1; $i++) {
                    $this->grid[$i][$col1] = '#';
                }
            }
        } else {
            if ($col1 < $col2) {
                for ($i = $col1; $i <= $col2; $i++) {
                    $this->grid[$row1][$i] = '#';
                }
            } else {
                for ($i = $col2; $i <= $col1; $i++) {
                    $this->grid[$row1][$i] = '#';
                }
            }
        }

    }

    private function fillGrid(): void
    {
        $this->fillOutside();
        $this->fillInside();

    }

    private function floodFill($x, $y, $target, $replacement): void
    {
        $rows = count($this->grid);
        $cols = count($this->grid[0]);

        // Buiten grenzen of al gevuld
        if ($x < 0 || $x >= $cols || $y < 0 || $y >= $rows) {
            return;
        }

        if ($this->grid[$y][$x] !== $target) {
            return;
        }

        // Vervang het karakter
        $this->grid[$y][$x] = $replacement;

        // Recursief de 4 aangrenzende cellen vullen
        $this->floodFill($x + 1, $y, $target, $replacement);
        $this->floodFill($x - 1, $y, $target, $replacement);
        $this->floodFill($x, $y + 1, $target, $replacement);
        $this->floodFill($x, $y - 1, $target, $replacement);
    }

    private function fillOutside(): void
    {
        $rows = count($this->grid);
        $cols = count($this->grid[0]);

        for ($x = 0; $x < $cols; $x++) {
            $this->floodFill($x, 0, '.', 'O');
            $this->floodFill($x, $rows - 1, '.', 'O');
        }
        for ($y = 0; $y < $rows; $y++) {
            $this->floodFill(0, $y, '.', 'O');
            $this->floodFill($cols - 1, $y, '.', 'O');
        }
    }

    private function fillInside(): void
    {
        foreach ($this->grid as &$row) {
            foreach ($row as &$cell) {
                if ($cell === '.') {
                    $cell = '#';
                } elseif ($cell === 'O') {
                    $cell = '.';
                }
            }
        }
    }

    private function printGrid(): void
    {
        $string = '';
        foreach ($this->grid as $row) {
            $string .= implode('', $row);
            $string .= PHP_EOL;
        }

        dd($string);
    }


}
