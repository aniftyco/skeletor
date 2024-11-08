<?php

namespace NiftyCo\Skeletor;

use Composer\Script\Event;
use function Laravel\Prompts\{info, select};

class Skeletor
{
    public function __construct(private string $cwd, private Event $event)
    {
        //
    }

    public function select(string $label, array $options, int|string|null $default = null, int $scroll = 5, mixed $validate = null, string $hint = '', bool|string $required = true, ?Closure $transform = null): int|string
    {
        return select($label, $options, $default, $scroll, $validate, $hint, $required, $transform);
    }

    public function info(string $message): void
    {
        info($message);
    }
}
