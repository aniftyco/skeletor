<?php

namespace NiftyCo\Skeletor;

use Closure;
use Composer\Script\Event;
use Illuminate\Support\Collection;
use Laravel\Prompts\Concerns\Colors;
use Laravel\Prompts\Progress;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\note;
use function Laravel\Prompts\password;
use function Laravel\Prompts\pause;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;

class Skeletor
{
    use Colors;

    public string $workspace;

    /**
     * Create a new Skeletor instance.
     *
     * @param  string  $cwd  Current working directory
     * @param  Event  $event  Composer script event
     */
    public function __construct(private string $cwd, private Event $event)
    {
        $this->workspace = basename($this->cwd);
    }

    /**
     * Display a text input prompt.
     *
     * @param  string  $label  The label to display
     * @param  string  $placeholder  Placeholder text
     * @param  string  $default  Default value
     * @param  bool|string  $required  Whether the input is required
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  Closure|null  $transform  Transform callback
     * @return string The user's input
     */
    public function text(string $label, string $placeholder = '', string $default = '', bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string
    {
        return text(...get_defined_vars());
    }

    /**
     * Display a textarea input prompt.
     *
     * @param  string  $label  The label to display
     * @param  string  $placeholder  Placeholder text
     * @param  string  $default  Default value
     * @param  bool|string  $required  Whether the input is required
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  int  $rows  Number of rows to display
     * @param  Closure|null  $transform  Transform callback
     * @return string The user's input
     */
    public function textarea(string $label, string $placeholder = '', string $default = '', bool|string $required = false, mixed $validate = null, string $hint = '', int $rows = 5, ?Closure $transform = null): string
    {
        return textarea(...get_defined_vars());
    }

    /**
     * Display a password input prompt.
     *
     * @param  string  $label  The label to display
     * @param  string  $placeholder  Placeholder text
     * @param  bool|string  $required  Whether the input is required
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  Closure|null  $transform  Transform callback
     * @return string The user's input
     */
    public function password(string $label, string $placeholder = '', bool|string $required = false, mixed $validate = null, string $hint = 'Your input is masked for security.', ?Closure $transform = null): string
    {
        return password(...get_defined_vars());
    }

    /**
     * Display a confirmation prompt.
     *
     * @param  string  $label  The label to display
     * @param  bool  $default  Default value
     * @param  string  $yes  Text for "yes" option
     * @param  string  $no  Text for "no" option
     * @param  bool|string  $required  Whether the input is required
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  Closure|null  $transform  Transform callback
     * @return bool The user's choice
     */
    public function confirm(string $label, bool $default = true, string $yes = 'Yes', string $no = 'No', bool|string $required = false, mixed $validate = null, string $hint = 'Press Y for Yes, N for No.', ?Closure $transform = null): bool
    {
        return confirm(...get_defined_vars());
    }

    /**
     * Display a select prompt.
     *
     * @param  string  $label  The label to display
     * @param  array|Collection  $options  Available options
     * @param  int|string|null  $default  Default selected option
     * @param  int  $scroll  Number of items to show at once
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  bool|string  $required  Whether selection is required
     * @param  Closure|null  $transform  Transform callback
     * @return int|string Selected option
     */
    public function select(string $label, array|Collection $options, int|string|null $default = null, int $scroll = 5, mixed $validate = null, string $hint = 'Use arrow keys to navigate, enter to select.', bool|string $required = true, ?Closure $transform = null): int|string
    {
        return select(...get_defined_vars());
    }

    /**
     * Display a multiple selection prompt.
     *
     * @param  string  $label  The label to display
     * @param  array|Collection  $options  Available options
     * @param  array|Collection  $default  Default selected options
     * @param  int  $scroll  Number of items to show at once
     * @param  bool|string  $required  Whether selection is required
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  Closure|null  $transform  Transform callback
     * @return array Selected options
     */
    public function multiselect(string $label, array|Collection $options, array|Collection $default = [], int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = 'Use the space bar to select options.', ?Closure $transform = null): array
    {
        return multiselect(...get_defined_vars());
    }

    /**
     * Display a suggestion prompt.
     *
     * @param  string  $label  The label to display
     * @param  array|Collection|Closure  $options  Available options
     * @param  string  $placeholder  Placeholder text
     * @param  string  $default  Default value
     * @param  int  $scroll  Number of items to show at once
     * @param  bool|string  $required  Whether input is required
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  Closure|null  $transform  Transform callback
     * @return string User's selection
     */
    public function suggest(string $label, array|Collection|Closure $options, string $placeholder = '', string $default = '', int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = '', ?Closure $transform = null): string
    {
        return suggest(...get_defined_vars());
    }

    /**
     * Display a search prompt.
     *
     * @param  string  $label  The label to display
     * @param  Closure  $options  Callback to provide search options
     * @param  string  $placeholder  Placeholder text
     * @param  int  $scroll  Number of items to show at once
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  bool|string  $required  Whether selection is required
     * @param  Closure|null  $transform  Transform callback
     * @return int|string Selected option
     */
    public function search(string $label, Closure $options, string $placeholder = '', int $scroll = 5, mixed $validate = null, string $hint = 'Start typing to search, use arrow keys to navigate.', bool|string $required = true, ?Closure $transform = null): int|string
    {
        return search(...get_defined_vars());
    }

    /**
     * Display a multiple search prompt.
     *
     * @param  string  $label  The label to display
     * @param  Closure  $options  Callback to provide search options
     * @param  string  $placeholder  Placeholder text
     * @param  int  $scroll  Number of items to show at once
     * @param  bool|string  $required  Whether selection is required
     * @param  mixed  $validate  Validation callback
     * @param  string  $hint  Hint text to display
     * @param  Closure|null  $transform  Transform callback
     * @return array Selected options
     */
    public function multisearch(string $label, Closure $options, string $placeholder = '', int $scroll = 5, bool|string $required = false, mixed $validate = null, string $hint = 'Use the space bar to select options.', ?Closure $transform = null): array
    {
        return multisearch(...get_defined_vars());
    }

    /**
     * Display a pause prompt.
     *
     * @param  string  $message  Message to display
     * @return bool Always returns true
     */
    public function pause(string $message = 'Press enter to continue...'): bool
    {
        return pause(...get_defined_vars());
    }

    /**
     * Display a table.
     *
     * @param  array|Collection  $headers  Table headers
     * @param  array|Collection|null  $rows  Table rows
     */
    public function table(array|Collection $headers = [], array|Collection|null $rows = null): void
    {
        table(...get_defined_vars());
    }

    /**
     * Display a spinner while executing a callback.
     *
     * @param  string  $message  Message to display
     * @param  Closure|null  $callback  Callback to execute
     * @param  string|null  $success  Success message
     * @param  string|null  $error  Error message
     * @return mixed Result of the callback
     */
    public function spin(string $message = '', ?Closure $callback = null, ?string $success = null, ?string $error = null): mixed
    {
        try {
            $result = spin($callback, $message);
            $this->clearLastLine();

            if ($success) {
                $this->success($success);
            }

            return $result;
        } catch (\Throwable $e) {
            $this->clearLastLine();
            $this->error($error ?? $e->getMessage());

            return null;
        }

    }

    /**
     * Display a progress bar.
     *
     * @param  string  $label  The label to display
     * @param  iterable|int  $steps  Number of steps or iterable
     * @param  Closure|null  $callback  Callback to execute
     * @param  string  $hint  Hint text to display
     * @return array|Progress Progress instance or result array
     */
    public function progress(string $label, iterable|int $steps, ?Closure $callback = null, string $hint = ''): array|Progress
    {
        return progress(...get_defined_vars());
    }

    /**
     * Log a message.
     *
     * @param  string  $message  Message to log
     * @param  string|null  $type  Message type
     */
    public function log(string $message, ?string $type = null): void
    {
        note($message, $type);
    }

    /**
     * Display an alert message.
     *
     * @param  string  $message  Message to display
     */
    public function alert(string $message): void
    {
        $this->log($message, 'alert');
    }

    /**
     * Display a warning message.
     *
     * @param  string  $message  Message to display
     */
    public function warning(string $message): void
    {
        $this->log("{$this->yellow('⚠')} {$message}");
    }

    /**
     * Display a success message.
     *
     * @param  string  $message  Message to display
     */
    public function success(string $message): void
    {
        $this->log("{$this->green('✔')} {$message}");
    }

    /**
     * Display an error message.
     *
     * @param  string  $message  Message to display
     */
    public function error(string $message): void
    {
        $this->log("{$this->red('x')} {$message}");
    }

    /**
     * Display an intro message.
     *
     * @param  string  $message  Message to display
     */
    public function intro(string $message): void
    {
        $this->log($message, 'intro');
    }

    /**
     * Display an outro message.
     *
     * @param  string  $message  Message to display
     */
    public function outro(string $message): void
    {
        $this->log($message, 'outro');
    }

    /**
     * Execute a callback with a value and return the value.
     *
     * @param  mixed  $value  Value to pass to callback
     * @param  Closure  $callback  Callback to execute
     * @return mixed Original value
     */
    public function tap(mixed $value, Closure $callback): mixed
    {
        $callback($value);

        return $value;
    }

    /**
     * Execute a shell command.
     *
     * @param  array  $command  Command and arguments
     * @param  string|null  $cwd  Working directory
     * @param  array|null  $env  Environment variables
     * @param  mixed  $input  Input to the command
     * @param  float|null  $timeout  Timeout in seconds
     * @param  callable|null  $callback  Callback for process output
     * @return Process The executed process
     */
    public function exec(array $command, ?string $cwd = null, ?array $env = null, mixed $input = null, ?float $timeout = 60, ?callable $callback = null): Process
    {
        return $this->tap(new Process($command, $cwd, $env, $input, $timeout), function (Process $process) {
            $process->run();
        });
    }

    /**
     * Read contents from a file.
     *
     * @param  string  $filename  Path to file
     * @return string File contents
     */
    public function readFile(string $filename): string
    {
        return file_get_contents(...get_defined_vars());
    }

    /**
     * Write data to a file.
     *
     * @param  string  $filename  Path to file
     * @param  string  $data  Data to write
     * @return bool|int Number of bytes written or false on failure
     */
    public function writeFile(string $filename, string $data): bool|int
    {
        return file_put_contents(...get_defined_vars());
    }

    /**
     * Remove a file.
     *
     * @param  string  $filename  Path to file
     * @return bool True on success
     */
    public function removeFile(string $filename): bool
    {
        return @unlink(...get_defined_vars());
    }

    /**
     * Replace text in a file.
     *
     * @param  string|array  $search  Text to search for
     * @param  string|array  $replace  Replacement text
     * @param  string  $file  Path to file
     */
    public function replaceInFile(string|array $search, string|array $replace, string $file): void
    {
        file_put_contents(
            $file,
            str_replace($search, $replace, file_get_contents($file))
        );
    }

    /**
     * Replace text in a file using regular expression.
     *
     * @param  string  $pattern  Regular expression pattern
     * @param  string  $replace  Replacement text
     * @param  string  $file  Path to file
     */
    public function pregReplaceInFile(string $pattern, string $replace, string $file): void
    {
        file_put_contents(
            $file,
            preg_replace($pattern, $replace, file_get_contents($file))
        );
    }

    /**
     * Remove a directory.
     *
     * @param  string  $filename  Path to directory
     * @return bool True on success
     */
    public function removeDirectory(string $filename): bool
    {
        return @rmdir(...get_defined_vars());
    }

    /**
     * Check if a file or directory exists.
     *
     * @param  string  $filename  Path to check
     * @return bool True if exists
     */
    public function exists(string $filename): bool
    {
        return file_exists(...get_defined_vars());
    }

    /**
     * Update composer.json with new data.
     *
     * @param  array  $data  Data to merge into composer.json
     * @return bool|int Number of bytes written or false on failure
     */
    public function updateComposerJson(array $data): bool|int
    {
        $composerJson = json_decode($this->readFile($this->cwd.'/composer.json'), true);

        foreach ($data as $key => $value) {
            $composerJson[$key] = $value;
        }

        return $this->writeFile($this->cwd.'/composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Clear the last line from the terminal output.
     */
    private function clearLastLine(): void
    {
        echo "\033[1A\033[K"; // erase previous line
    }
}
