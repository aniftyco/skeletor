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

## Available Methods

### Gathering User Input

#### Text Input

```php
$skeletor->text('Enter your name:', 'John Doe');
```

#### Textarea Input

```php
$skeletor->textarea('Enter a description:');
```

#### Password Input

```php
$skeletor->password('Enter your password:');
```

#### Confirm

```php
$skeletor->confirm('Do you agree?', true);
```

#### Select

```php
$skeletor->select('Choose an option:', ['Option 1', 'Option 2', 'Option 3']);
```

#### Multiselect

```php
$skeletor->multiselect('Choose multiple options:', ['Option 1', 'Option 2', 'Option 3']);
```

#### Suggest

```php
$skeletor->suggest('Start typing:', ['Suggestion 1', 'Suggestion 2', 'Suggestion 3']);
```

#### Search

```php
$skeletor->search('Search for an option:', function ($query) {
    return ['Result 1', 'Result 2', 'Result 3'];
});
```

#### Multisearch

```php
$skeletor->multisearch('Search for multiple options:', function ($query) {
    return ['Result 1', 'Result 2', 'Result 3'];
});
```

### Displaying Information

#### Spinner

```php
$skeletor->spin('Processing...', function () {
    // long running task
    return true;
});
```

#### Progress Bar

```php
$skeletor->progress('Processing items...', 100, function ($progress) {
    for ($i = 0; $i < 100; $i++) {
        $progress->advance();
    }
});
```

#### Messages

```php
$skeletor->info('This is an info message.');

$skeletor->alert('This is an alert message.');

$skeletor->warning('This is a warning message.');

$skeletor->error('This is an error message.');

$skeletor->intro('Welcome to the setup wizard.');

$skeletor->outro('Setup complete.');
```

### File Operations

#### Reading a File

```php
$skeletor->readFile('path/to/file.txt');
```

#### Writing to a File

```php
$skeletor->writeFile('path/to/file.txt', 'New content');
```

#### Removing a File

```php
$skeletor->removeFile('path/to/file.txt');
```

#### Removing a Directory

```php
$skeletor->removeDirectory('path/to/directory');
```

#### Checking if a File Exists

```php
$skeletor->exists('path/to/file.txt');
```

#### Updating composer.json

```php
$skeletor->updateComposerJson(['require' => ['new/package' => '^1.0']]);
```

#### Executing a Command

```php
$skeletor->exec(['ls', '-la']);
```

#### Table

```php
$skeletor->table(['Header 1', 'Header 2'], [['Row 1 Col 1', 'Row 1 Col 2'], ['Row 2 Col 1', 'Row 2 Col 2']]);
```

#### Pause

```php
$skeletor->pause(5);
```

#### Replace In File

```php
$skeletor->replaceInFile('path/to/file.txt', 'search string', 'replace string');
```

#### Preg Replace In File

```php
$skeletor->pregReplaceInFile('path/to/file.txt', '/pattern/', 'replace string');
```
