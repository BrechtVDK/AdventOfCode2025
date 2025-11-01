<?php

namespace App\Solutions;

abstract class AbstractSolution
{
    protected string $input;
    protected array $parsedInput;
    protected int $year;
    protected int $day;

    public function __construct(int $year, int $day, bool $useExample = false)
    {
        $this->year = $year;
        $this->day = $day;
        $this->input = load_input($year, $day, $useExample);
        $this->parsedInput = $this->parseInput();
    }

    abstract public function silver(): int|string;

    abstract public function gold(): int|string;

    abstract protected function parseInput(): array;

    protected function getLines(): array
    {
        return get_lines($this->input);
    }

    protected function getBlocks(): array
    {
        return get_blocks($this->input);
    }

    protected function getNumbers(string $line): array
    {
        return get_numbers($line);
    }

    public function solve(): array
    {
        return [
            'silver' => $this->silver(),
            'gold' => $this->gold(),
        ];
    }

    public function benchmark(callable $method, int $iterations = 100): float
    {
        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $method();
        }
        return (microtime(true) - $start) / $iterations;
    }
}
