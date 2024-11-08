<?php

namespace NiftyCo\Skeletor;

use Composer\Script\Event;

class Runner
{
    public static function execute(Event $event): void
    {
        require_once __DIR__ . '/../../../autoload.php';

        $cwd = getcwd();

        $skeletor = new Skeletor($cwd, $event);

        try {
            $handler = require_once $cwd . '/Skeletorfile.php';
            $handler($skeletor);
        } catch (\Throwable $e) {
            $event->getIO()->error($e->getMessage());
        }
    }
}
