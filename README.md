# Skeletor

> Summon Skeletor's minion: a Composer companion to unleash extra functionality with every `create-project` command.

> [!WARNING]
> This package is not ready for general consumption

## Installation

```sh
composer install --dev aniftyco/skeletor:dev-master
```

## Usage

Make sure the following is set in the `scripts` section of `composer.json`:

```json
"post-create-project-cmd": [
    "NiftyCo\\Skeletor\\Runner::execute"
],
```

Then just create a `Skeletorfile.php` in the root with this:

```php
<?php

use NiftyCo\Skeletor\Skeletor;

return function (Skeletor $skeletor) {
    // ...
};
```

### Available methods on `Skeletor::class`:

- `text(string $label, string $placeholder = '', string $default = '', bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string`
- `textarea(string $label, string $placeholder = '', string $default = '', bool|string $required = false, mixed $validate = null, string $hint = '', int $rows = 5, ?Closure $transform = null): string`
- `password(string $label, string $placeholder = '', bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string`
- `confirm(string $label, bool $default = true, string $yes = 'Yes', string $no = 'No', bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): bool`
- `select(string $label, array|Collection $options, int|string|null $default = null, int $scroll = 5, mixed $validate = null, string $hint = '', bool|string $required = true, ?Closure $transform = null): int|string`
- `multiselect(string $label, array|Collection $options, array|Collection $default = [], int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = 'Use the space bar to select options.', ?Closure $transform = null): array`
- `suggest(string $label, array|Collection|Closure $options, string $placeholder = '', string $default = '', int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string`
- `search(string $label, Closure $options, string $placeholder = '', int $scroll = 5, mixed $validate = null, string $hint = '', bool|string $required = true, ?Closure $transform = null): int|string`
- `multisearch(string $label, Closure $options, string $placeholder = '', int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = 'Use the space bar to select options.', ?Closure $transform = null): array`
- `pause(string $message = 'Press enter to continue...'): bool`
- `table(array|Collection $headers = [], array|Collection|null $rows = null): void`
- `spin(string $message = '', Closure $callback = null): mixed`
- `progress(string $label, iterable|int $steps, ?Closure $callback = null, string $hint = ''): array|Progress`
- `info(string $message): void`
- `alert(string $message): void`
- `warning(string $message): void`
- `error(string $message): void`
- `intro(string $message): void`
- `outro(string $message): void`
- `exec(array $command, ?string $cwd = null, ?array $env = null, mixed $input = null, ?float $timeout = 60, ?callable $callback = null): Process`
- `readFile(string $filename): string`
- `writeFile(string $filename, string $data): bool|int`
- `removeFile(string $filename): bool`
- `removeDirectory(string $filename): bool`
- `exists(string $filename): bool`
- `updateComposerJson(array $data): bool|int`
