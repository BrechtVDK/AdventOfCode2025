<?php

namespace App\Solutions\Year_2024;

class Solution_01
{
    public string $input;

    public function __construct()
    {
        $this->input = load_input(2024, 1, false);
    }

    public function silver(string $data): string
    {

        [$leftColumn, $rightColumn] = $this->readInput();

        sort($leftColumn);
        sort($rightColumn);

        $total = 0;

        for ($i = 0; $i < count($leftColumn); $i++) {
            $total += abs($leftColumn[$i] - $rightColumn[$i]);
        }

        return $total;
    }

    public function gold(string $data): string
    {

        [$leftColumn, $rightColumn] = $this->readInput();

        $counts = array_count_values($rightColumn);
        $total = 0;
        foreach ($leftColumn as $number) {
            $total += $number * ($counts[$number] ?? 0);
        }
        return $total;

    }

    private function readInput(): array
    {
        $leftColumn = $rightColumn = [];

        foreach (explode("\n", trim($this->input)) as $line) {
            if (!$line) continue;

            sscanf($line, '%d %d', $left, $right);
            $leftColumn[] = $left;
            $rightColumn[] = $right;
        }
        return [$leftColumn, $rightColumn];
    }

}
