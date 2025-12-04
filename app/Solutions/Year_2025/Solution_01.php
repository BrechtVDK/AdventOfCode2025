<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_01 extends AbstractSolution
{
    private int $pointingZeroCount = 0;

    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 01, $useExample);
    }

    protected function parseInput(): array
    {
        return $this->getLines();
    }

    public function silver(): int|string
    {

        $pointingAt = 50;
        foreach ($this->parsedInput as $rotation) {
            $clicks = (int)substr($rotation, 1) % 100;
            $pointingAt = match ($rotation[0]) {
                'L' => $this->turnLeft($pointingAt, $clicks),
                'R' => $this->turnRight($pointingAt, $clicks),
            };
        }
        return $this->pointingZeroCount;
    }

    public function gold(): int|string
    {
        $pointingAt = 50;
        $this->pointingZeroCount = 0;

        foreach ($this->parsedInput as $rotation) {
            $clicks = (int)substr($rotation, 1);
            $pointingAt = match ($rotation[0]) {
                'L' => $this->turnLeft($pointingAt, $clicks, true),
                'R' => $this->turnRight($pointingAt, $clicks, true),
            };
        }
        return $this->pointingZeroCount;

    }

    private
    function turnLeft(int $pointingAt, int $clicks, ?bool $gold = false): int
    {
        for ($i = 0; $i < $clicks; ++$i) {
            if (--$pointingAt < 0) {
                $pointingAt += 100;
            }
            if (($gold || $i === $clicks - 1) && $pointingAt === 0) {
                $this->pointingZeroCount++;
            }
        }

        return $pointingAt;
    }

    private
    function turnRight(int $pointingAt, int $clicks, ?bool $gold = false): int
    {
        for ($i = 0; $i < $clicks; ++$i) {
            if (++$pointingAt > 99) {
                $pointingAt -= 100;
            }
            if (($gold || $i === $clicks - 1) && $pointingAt === 0) {
                $this->pointingZeroCount++;
            }
        }
        return $pointingAt;
    }
}
