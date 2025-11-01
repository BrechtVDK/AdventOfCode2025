<?php

use GuzzleHttp\Client;

if (!function_exists('instanciate_solution')) {
    function instanciate_solution($year, $day)
    {
        $classname = sprintf('App\\Solutions\\Year_%s\\Solution_%s', $year, sprintf('%02d', $day));

        if (!class_exists($classname)) {
            return null;
        }

        return new $classname();
    }
}

if (!function_exists('load_input')) {
    function load_input($year, $day, bool $example = false): ?string
    {
        $data_filename = sprintf('resources/inputs/%s/%s.%s', $year, sprintf('%02d', $day), $example ? 'example' : 'txt');
        if (!file_exists($data_filename)) {
            return null;
        }

        return file_get_contents($data_filename);
    }
}

if (!function_exists('file_force_contents')) {
    function file_force_contents(string $filename, $data, int $flags = 0)
    {
        $dir = implode('/', explode('/', $filename, -1));
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        file_put_contents($filename, $data, $flags);
    }
}

if (!function_exists('get_client_to_aoc_website')) {
    function get_client_to_aoc_website(?string $url = null)
    {
        if (!$url) {
            $url = 'https://adventofcode.com/';
        }

        if (config('services.github.username') == null
            || config('services.github.email') == null
            || config('services.github.repository') == null) {
            throw new Exception('Please fill in your github username, email and repository in your .env file');
        }

        $user_agent = sprintf(
            'github.com/%s/%s by %s',
            config('app.github_username'),
            config('app.github_repository'),
            config('app.github_email')
        );

        return new Client([
            'base_uri' => $url,
            'headers' => [
                'User-Agent' => $user_agent,
                'Cookie' => 'session=' . config('services.adventofcode.session_cookie'),
            ],
        ]);
    }
}

if (!function_exists('update_env_session_cookie')) {
    function update_env_session_cookie(string $session)
    {
        $env = file('.env', FILE_IGNORE_NEW_LINES);

        foreach ($env as $i => $line) {
            if (str_starts_with($line, 'AOC_SESSION_COOKIE')) {
                $env[$i] = "AOC_SESSION_COOKIE=$session";
                break;
            }
        }

        file_put_contents('.env', implode(PHP_EOL, $env));
    }

    if (!function_exists('get_lines')) {
        function get_lines(string $input): array
        {
            return explode("\n", trim($input));
        }

    }
    if (!function_exists('get_blocks')) {
        function get_blocks(string $input): array
        {
            return array_map('trim', explode("\n\n", trim($input)));
        }
    }

    if (!function_exists('get_grid')) {
        function get_grid(string $input): array
        {
            return array_map('str_split', get_lines($input));
        }
    }

    if (!function_exists('get_numbers')) {
        function get_numbers(string $input): array
        {
            preg_match_all('/-?\d+/', $input, $matches);
            return array_map('intval', $matches[0]);
        }
    }

    if (!function_exists('get_char_counts')) {
        function get_char_counts(string $input): array
        {
            return count_chars($input, 1);
        }
    }

    if (!function_exists('parse_coords')) {
        function parse_coords(string $line, string $pattern = '/(-?\d+)/'):array
        {
            preg_match_all($pattern, $line, $matches);
            return array_map('intval', $matches[1]);
        }
    }

    if (!function_exists('neighbors_4')) {
        function neighbors_4(int $row, int $col): array
        {
            return [
                [$row - 1, $col],
                [$row, $col + 1],
                [$row + 1, $col],
                [$row, $col - 1],
            ];
        }
    }

    if (!function_exists('neighbors_8')) {
        function neighbors_8(int $row, int $col): array
        {
            $neighbors = [];
            for ($dr = -1; $dr <= 1; $dr++) {
                for ($dc = -1; $dc <= 1; $dc++) {
                    if ($dr === 0 && $dc === 0) continue;
                    $neighbors[] = [$row + $dr, $col + $dc];
                }
            }
            return $neighbors;
        }
    }

    if (!function_exists('in_bounds')) {
        function in_bounds(int $row, int $col, array $grid): bool
        {
            return $row >= 0 && $row < count($grid) &&
                $col >= 0 && $col < count($grid[0]);
        }
    }

    if (!function_exists('transpose')) {
        function transpose(array $grid): array
        {
            return array_map(null, ...$grid);
        }
    }

    if (!function_exists('rotate_right')) {
        function rotate_right(array $grid): array
        {
            return array_map('array_reverse', transpose($grid));
        }
    }

    if (!function_exists('manhattan_distance')) {
        function manhattan_distance(array $p1, array $p2): int
        {
            return abs($p1[0] - $p2[0]) + abs($p1[1] - $p2[1]);
        }
    }
}
