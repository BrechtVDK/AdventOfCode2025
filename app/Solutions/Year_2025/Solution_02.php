<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_02 extends AbstractSolution
{
    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 02, $useExample);
    }

    protected function parseInput(): array
    {
        return explode(",", trim($this->input));
    }

    public function silver(): int|string
    {
        $sum = 0;
        foreach ($this->parseInput() as $range) {
            $exploded = explode("-", $range);
            $start = intval($exploded[0]);
            $end = intval($exploded[1]);
            for ($id = $start; $id <= $end; $id++) {
                if ($this->isInvalidIdSilver($id)) {
                    $sum += $id;
                }
            }
        }
        return $sum;
    }

    public function gold(): int|string
    {
        $sum = 0;
        foreach ($this->parseInput() as $range) {
            $exploded = explode("-", $range);
            $start = intval($exploded[0]);
            $end = intval($exploded[1]);
            for ($id = $start; $id <= $end; $id++) {
                if ($this->isInvalidIdGold($id)) {
                    $sum += $id;
                }
            }
        }
        return $sum;
    }


    private function isInvalidIdSilver(int $id): bool
    {
        $len = strlen($id);
        if ($len % 2 !== 0) {
            return false;
        }
        $split = str_split($id, $len / 2);
        return $split[0] === $split[1];
    }

    private function isInvalidIdGold(int $id): bool
    {

        $len = strlen($id);
        $middle = intdiv($len, 2);

        for ($i = 1; $i <= $middle; $i++) {
            $split = str_split($id, $i);
            if (array_all($split, function (string $value) use ($split) {
                return $value ===$split[0];
            })) {
                return true;
            }

        }
        return false;
    }
}
