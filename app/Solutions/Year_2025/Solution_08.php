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
        $this->connect();

        uasort($this->circuits, function ($a, $b) {
            return count($b) <=> count($a);
        });
        $this->circuits = array_values($this->circuits);
        ray($this->circuits);


        return count($this->circuits[0]) * count($this->circuits[1]) * count($this->circuits[2]);

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

    private function connect(): void
    {
        $maxLoops = $this->useExample ? 10 : 1000;
        $loop = 0;
        foreach ($this->map as $junctionBoxes => $distance) {
            $loop++;
            if ($loop > $maxLoops) break;

            $flag = false;
            $junctionBoxArray = $this->splitInArray($junctionBoxes);
          //  ray($this->circuits);
           // ray($junctionBoxArray);
            if ($this->areInSameCircuit($junctionBoxArray)) {
                continue;
            };
            if ($circuits = $this->areBothInDifferentCircuit($junctionBoxArray)) {
                $this->circuits[$circuits[0]] = array_merge($this->circuits[$circuits[0]], $this->circuits[$circuits[1]]);
                unset($this->circuits[$circuits[1]]);
                $this->circuits = array_values($this->circuits);
                continue;
            }
            for ($i = 0; $i < 2; $i++) {
                $circuit = $this->alreadyInCircuit($junctionBoxArray[$i]);
                if ($circuit !== false) {
                    $this->circuits[$circuit][] = $junctionBoxArray[$i === 0 ? 1 : 0];
                    $flag = true;
                    break;
                }
            }

            if (!$flag) {
                $this->circuits[] = $junctionBoxArray;
            }

        }

    }

    private function splitInArray($string): array
    {
        return explode('-', $string);

    }

    private function alreadyInCircuit(mixed $junctionBox): bool|int
    {
        for ($i = 0; $i < count($this->circuits); $i++) {
            if (in_array($junctionBox, $this->circuits[$i])) {
                return $i;
            }
        }
        return false;

    }

    private function areInSameCircuit(array $junctionBoxArray): bool
    {
        return array_any($this->circuits, function ($circuit) use ($junctionBoxArray) {
            return array_all($junctionBoxArray, function ($junctionBox) use ($circuit) {
                return array_search($junctionBox, $circuit);
            });
        });
    }

    private
    function areBothInDifferentCircuit(array $junctionBoxArray): bool|array
    {
        $circuit1 = -1;
        $circuit2 = -1;
        for ($i = 0; $i < count($this->circuits); $i++) {
            if (in_array($junctionBoxArray[0], $this->circuits[$i])) {
                $circuit1 = $i;
                break;
            }
        }
        if ($circuit1 !== -1) {
            for ($i = 0; $i < count($this->circuits); $i++) {
                if (in_array($junctionBoxArray[1], $this->circuits[$i])) {
                    $circuit2 = $i;
                    return [$circuit1, $circuit2];
                }
            }
        } else {
            return false;
        }

        return false;

    }


}
