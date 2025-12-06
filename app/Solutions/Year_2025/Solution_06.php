<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_06 extends AbstractSolution
{
    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 06, $useExample);
    }

    protected function parseInput(): array
    {
        return transpose(array_map(function ($line) {
            return preg_split('/\s+/', trim($line));
        }, $this->getLines()));
    }

    public function silver(): int|string
    {
        $total = 0;
        foreach ($this->parsedInput as $problem) {
            $total += match ($problem[count($problem) - 1]) {
                '*' => array_product(array_slice($problem, 0, -1)),
                '+' => array_sum(array_slice($problem, 0, -1)),
            };
        }
        return $total;
    }

    public function gold(): int|string
    {
        $parsedInput = [];
        $lines = $this->getLines();
        $numberOfLines = count($lines);

        $maxLength = max(array_map('strlen', $lines));
        $lines = array_map(function ($line) use ($maxLength) {
            return str_pad($line, $maxLength, ' ', STR_PAD_RIGHT);
        }, $lines);

        $problem = array_fill(0, $numberOfLines, '');
        for ($col = 0; $col <= $maxLength; $col++) {
            if ($col === $maxLength || $this->isEmptyColumn($col, $lines)) {
                $problem[$numberOfLines - 1] = trim($problem[$numberOfLines - 1]);
                $parsedInput[] = $problem;
                $problem = array_fill(0, $numberOfLines, '');
            } else {
                for ($line = 0; $line < count($lines); $line++) {
                    $problem[$line] = $problem[$line] . substr($lines[$line], $col, 1);
                }
            }

        }

        $total = 0;
        foreach ($parsedInput as $problem) {
            $cephalopodProblem = $this->getCephalopodProblem($problem);
            $total += match ($cephalopodProblem[count($cephalopodProblem) - 1]) {
                '*' => array_product(array_slice($cephalopodProblem, 0, -1)),
                '+' => array_sum(array_slice($cephalopodProblem, 0, -1)),
            };
        }
        return $total;
    }

    private
    function getCephalopodProblem(array $problem): array
    {
        $cephalopodProblem = [];
        $len = count($problem);

        $numberOfColumns = strlen(max($problem));
        $problem = array_map(function ($number) use ($numberOfColumns) {
            return str_pad($number, $numberOfColumns, ' ', STR_PAD_LEFT);
        }, $problem);

        for ($i = 0; $i < $numberOfColumns; $i++) {
            $newNumber = '';
            for ($number = 0; $number < $len - 1; $number++) {
                $newNumber .= substr($problem[$number], $i, 1);
            }
            $cephalopodProblem[] = trim($newNumber);
        }
        $cephalopodProblem[] = trim($problem[$len - 1]);

        return $cephalopodProblem;
    }

    private function isEmptyColumn(int $col, array $lines): bool
    {
        return array_all($lines, function ($line) use ($col) {
            return $line[$col] === ' ';
        });
    }

}
