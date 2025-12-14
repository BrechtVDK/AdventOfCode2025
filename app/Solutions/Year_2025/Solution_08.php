<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_08 extends AbstractSolution
{

    private array $map = [];
    private array $circuits = [];
    private array $flagJunctionBoxes = [];

    public function __construct(protected bool $useExample = false)
    {
        parent::__construct(2025, 8, $useExample);
        $this->mapDistancesAndSort();
    }

    protected function parseInput(): array
    {
        return array_map(function ($line) {
            return explode(',', $line);
        },
            $this->getLines());
    }

    public function silver(): int|string
    {

        for ($i = 0; $i < count($this->parsedInput); $i++) {
            $this->circuits[$i] = [];
        }

        // ray($this->map);
        //ray($this->circuits);
        $loops = $this->useExample ? 10 : 1000;
        for ($i = 0; $i <= $loops; $i++) {
            $points = explode('-', array_key_first($this->map));
            array_shift($this->map);
            $this->connect($points[0], $points[1]);
        }
        $this->reduceCircuits();


        uasort($this->circuits, function ($a, $b) {
            return count($b) <=> count($a);
        });

        $total = 1;
        $i = 0;
        foreach ($this->circuits as $circuit) {
            $total *= count($circuit) + 1;
            if (++$i === 3) break;
        }

        return $total;

    }

    public function gold(): int|string
    {
        // Solve part 2 using $this->parsedInput
        return 'todo';
    }


    private function mapDistancesAndSort(): void
    {
        $totalJunctions = count($this->parsedInput);

        for ($i = 0; $i < $totalJunctions - 1; $i++) {
            for ($j = $i + 1; $j < $totalJunctions; $j++) {
                $this->map[$i . '-' . $j] = $this->getDistance($i, $j);
            }
        }
        asort($this->map);


    }

    private function getDistance(int $i, int $j): float
    {
        $junction1 = $this->parsedInput[$i];
        $junction2 = $this->parsedInput[$j];

        return sqrt(pow(($junction1[0] - $junction2[0]), 2) + pow(($junction1[1] - $junction2[1]), 2) + pow(($junction1[2] - $junction2[2]), 2));


    }

    private function connect($point1, $point2): void
    {
        $this->circuits[$point1][] = $point2;
        $this->circuits[$point2][] = $point1;
    }

    private function reduceCircuits(): void
    {
        $count = count($this->circuits);
        foreach ($this->circuits as $key => $circuit) {
            $common = [];
            $common[] = $key;
            for ($j = 0; $j < $count; $j++) {
                if ($key === $j) continue;
                if (in_array($key, $this->circuits[$j])) {
                    $common[] = $j;
                }
            }

            $longest = -1;
            $longestC = -1;
            foreach ($common as $c) {
                $len = count($this->circuits[$c]);
                if ($len > $longest) {
                    $longest = $len;
                    $longestC = $c;
                }
            }
            foreach ($common as $c) {
                if ($c === $longestC) continue;
                $this->circuits[$c] = [];
            }
        }
    }


}
