<?php

namespace NiftyCo\Skeletor;

use Closure;
use Composer\Script\Event;
use Illuminate\Support\Collection;
use Laravel\Prompts\Progress;
use Symfony\Component\Process\Process;
use function Laravel\Prompts\{
    text,
    textarea,
    password,
    confirm,
    select,
    multiselect,
    suggest,
    search,
    multisearch,
    pause,
    table,
    spin,
    progress,
    info,
    alert,
    warning,
    error,
    intro,
    outro,
};

class Skeletor
{
    public function __construct(private string $cwd, private Event $event)
    {
        //
    }

    public function text(string $label, string $placeholder = '', string $default = '', bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string
    {
        return text(...get_defined_vars());
    }

    public function textarea(string $label, string $placeholder = '', string $default = '', bool|string $required = false, mixed $validate = null, string $hint = '', int $rows = 5, ?Closure $transform = null): string
    {
        return textarea(...get_defined_vars());
    }

    public function password(string $label, string $placeholder = '', bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string
    {
        return password(...get_defined_vars());
    }

    public function confirm(string $label, bool $default = true, string $yes = 'Yes', string $no = 'No', bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): bool
    {
        return confirm(...get_defined_vars());
    }

    public function select(string $label, array|Collection $options, int|string|null $default = null, int $scroll = 5, mixed $validate = null, string $hint = '', bool|string $required = true, ?Closure $transform = null): int|string
    {
        return select(...get_defined_vars());
    }

    public function multiselect(string $label, array|Collection $options, array|Collection $default = [], int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = 'Use the space bar to select options.', ?Closure $transform = null): array
    {
        return multiselect(...get_defined_vars());
    }

    public function suggest(string $label, array|Collection|Closure $options, string $placeholder = '', string $default = '', int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string
    {
        return suggest(...get_defined_vars());
    }

    public function search(string $label, Closure $options, string $placeholder = '', int $scroll = 5, mixed $validate = null, string $hint = '', bool|string $required = true, ?Closure $transform = null): int|string
    {
        return search(...get_defined_vars());
    }

    public function multisearch(string $label, Closure $options, string $placeholder = '', int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = 'Use the space bar to select options.', ?Closure $transform = null): array
    {
        return multisearch(...get_defined_vars());
    }

    public function pause(string $message = 'Press enter to continue...'): bool
    {
        return pause(...get_defined_vars());
    }

    public function table(array|Collection $headers = [], array|Collection|null $rows = null): void
    {
        table(...get_defined_vars());
    }

    public function spin(Closure $callback, string $message = ''): mixed
    {
        return spin(...get_defined_vars());
    }

    public function progress(string $label, iterable|int $steps, ?Closure $callback = null, string $hint = ''): array|Progress
    {
        return progress(...get_defined_vars());
    }

    public function info(string $message): void
    {
        info(...get_defined_vars());
    }

    public function alert(string $message): void
    {
        alert(...get_defined_vars());
    }

    public function warning(string $message): void
    {
        warning(...get_defined_vars());
    }

    public function error(string $message): void
    {
        error(...get_defined_vars());
    }

    public function intro(string $message): void
    {
        intro(...get_defined_vars());
    }

    public function outro(string $message): void
    {
        outro(...get_defined_vars());
    }

    public function exec(array $command, ?string $cwd = null, ?array $env = null, mixed $input = null, ?float $timeout = 60, ?callable $callback = null): Process
    {
        $process = new Process($command, $cwd, $env, $input, $timeout);

        $process->run($callback);

        return $process;
    }

    public function readFile(string $filename): string
    {
        return file_get_contents(...get_defined_vars());
    }

    public function writeFile(string $filename, string $data): bool|int
    {
        return file_put_contents(...get_defined_vars());
    }

    public function removeFile(string $filename): bool
    {
        return @unlink(...get_defined_vars());
    }

    public function removeDirectory(string $filename): bool
    {
        return @rmdir(...get_defined_vars());
    }

    public function exists(string $filename): bool
    {
        return file_exists(...get_defined_vars());
    }

    public function updateComposerJson(array $data): bool|int
    {
        $composerJson = json_decode($this->readFile($this->cwd . '/composer.json'), true);

        foreach ($data as $key => $value) {
            $composerJson[$key] = $value;
        }

        return $this->writeFile($this->cwd . '/composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
