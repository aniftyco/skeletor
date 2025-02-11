<?php

namespace NiftyCo\Skeletor;

use Composer\Script\Event;
use Symfony\Component\Process\Process;

class Runner
{
    public static ?Event $event = null;

    public static ?string $cwd = null;

    public static function execute(Event $event): void
    {
        static::$event = $event;
        static::$cwd = getcwd();

        require_once __DIR__.'/../../../autoload.php';

        $skeletor = new Skeletor(static::$cwd, $event);

        try {
            $handler = require_once static::$cwd.'/Skeletorfile.php';
            $cleanup = $handler($skeletor);

            if ((bool) getenv('NO_SKELETOR_CLEANUP') === false) {
                static::cleanup();

                if (is_callable($cleanup)) {
                    call_user_func($cleanup);
                }
            }
        } catch (\Throwable $e) {
            $event->getIO()->error($e->getMessage());
        }
    }

    private static function cleanup(): void
    {
        $composerJson = json_decode(file_get_contents(static::$cwd.'/composer.json'), true);

        @unlink(static::$cwd.'/Skeletorfile.php');

        unset($composerJson['scripts']['post-create-project-cmd']);

        @file_put_contents(static::$cwd.'/composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $process = new Process(['composer', 'remove', '--quiet', '--no-interaction', '--dev', 'aniftyco/skeletor']);
        $process->disableOutput();
        $process->run(null, ['stderr' => false]);
    }
}
