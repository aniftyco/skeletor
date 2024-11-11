<?php

namespace NiftyCo\Skeletor;

use Composer\Script\Event;
use function Laravel\Prompts\{info, warning, error, select};

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

    public function warning(string $message): void
    {
        warning($message);
    }

    public function error(string $message): void
    {
        error($message);
    }

    public function exec(string $command): bool|string
    {
        return exec($command);
    }

    public function readFile(string $path): string
    {
        return file_get_contents($path);
    }

    public function writeFile(string $path, string $content): bool|int
    {
        return file_put_contents($path, $content);
    }

    public function removeFile(string $path): bool
    {
        return @unlink($path);
    }

    public function removeDirectory(string $path): bool
    {
        return @rmdir($path);
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
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
