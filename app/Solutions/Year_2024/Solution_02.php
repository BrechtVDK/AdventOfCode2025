<?php

namespace App\Solutions\Year_2024;

class Solution_02
{

    public string $input;

    public function __construct()
    {
        $this->input = load_input(2024, 2, false);
    }

    public function silver(string $data): string
    {
        $lines = $this->readInput();
        $safeCount = 0;
        foreach ($lines as $line) {
            if ($this->isLineSafe($line)) {
                $safeCount++;
            }
        }
        return $safeCount;

    }

    public function gold(string $data): string
    {
        $lines = $this->readInput();
        $safeCount = 0;

        foreach ($lines as $line) {
            if ($this->isLineSafeWithJoker($line)) {
                $safeCount++;
            }
        }

        return $safeCount;
    }

    private function readInput(): array
    {
        $lines = [];
        foreach (get_lines($this->input) as $line) {
            $lines[] = get_numbers($line);
        };
        return $lines;
    }

    private function isLineSafe(array $line): bool
    {
        $isDecreasing = $line[0] > $line[count($line) - 1];

        for ($i = 0; $i < count($line) - 1; $i++) {
            $absDiff = abs($line[$i] - $line[$i + 1]);
            if ($absDiff > 3 || $absDiff < 1) {
                return false;
            }

            if ($isDecreasing && $line[$i] <= $line[$i + 1]) {
                return false;
            }

            if (!$isDecreasing && $line[$i] >= $line[$i + 1]) {
                return false;
            }

        }
        return true;

    }

    private function isLineSafeWithJoker(array $line): bool
    {
        if ($this->isLineSafe($line)) {
            return true;
        }

        for ($i = 0; $i < count($line); $i++) {
            $modifiedLine = $line;
            array_splice($modifiedLine, $i, 1);

            if ($this->isLineSafe($modifiedLine)) {
                return true;
            }
        }

        return false;
    }
}
