<?php

namespace NiftyCo\Skeletor;

use Composer\Script\Event;

class Runner
{
    static ?Event $event = null;
    static ?string $cwd = null;

    public static function execute(Event $event): void
    {
        static::$event = $event;
        static::$cwd = getcwd();

        require_once __DIR__ . '/../../../autoload.php';

        $skeletor = new Skeletor(static::$cwd, $event);

        try {
            $handler = require_once static::$cwd . '/Skeletorfile.php';
            $handler($skeletor);
            if ((bool) getenv('NO_SKELETOR_CLEANUP') === false) {
                static::cleanup();
            }
        } catch (\Throwable $e) {
            $event->getIO()->error($e->getMessage());
        }
    }

    private static function cleanup(): void
    {
        $composerJson = json_decode(file_get_contents(static::$cwd . '/composer.json'), true);

        @unlink(static::$cwd . '/Skeletorfile.php');

        unset($composerJson['scripts']['post-create-project-cmd']);

        @file_put_contents(static::$cwd . '/composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        @exec('composer remove --dev aniftyco/skeletor');
    }
}
