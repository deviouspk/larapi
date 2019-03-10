<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10.03.19
 * Time: 18:30
 */

namespace Foundation\Generator\Managers;


class GeneratorManager
{
    public static function createMigration(string $moduleName, string $migrationName, string $tableName, bool $mongo = false)
    {
        $options = [
            "module" => $moduleName,
            "name" => $migrationName,
            "--table" => $tableName,
            "--mongo" => $mongo
        ];
        \Artisan::call("larapi:make:migration", $options);
    }

    public static function createController(string $moduleName, string $controllerName)
    {
        $options = [
            "module" => $moduleName,
            "name" => $controllerName,
        ];
        \Artisan::call("larapi:make:controller", $options);
    }

    public static function createEvent(string $moduleName, string $eventName)
    {
        $options = [
            "module" => $moduleName,
            "name" => $eventName,
        ];
        \Artisan::call("larapi:make:event", $options);
    }

    public static function createNotification(string $moduleName, string $notificationName)
    {
        $options = [
            "module" => $moduleName,
            "name" => $notificationName,
        ];
        \Artisan::call("larapi:make:notification", $options);
    }

    public static function createServiceProvider(string $moduleName, string $providerName)
    {
        $options = [
            "module" => $moduleName,
            "name" => $providerName,
        ];
        \Artisan::call("larapi:make:provider", $options);
    }

    public static function createMiddleware(string $moduleName, string $middlewareName)
    {
        $options = [
            "module" => $moduleName,
            "name" => $middlewareName,
        ];
        \Artisan::call("larapi:make:middleware", $options);
    }

    public static function createFactory(string $moduleName, string $modelName)
    {
        $options = [
            "module" => $moduleName,
            "--model" => $modelName,
        ];
        \Artisan::call("larapi:make:factory", $options);
    }

    public static function createListener(string $moduleName, string $listenerName, string $eventName, bool $queued = false)
    {
        $options = [
            "module" => $moduleName,
            "name" => $listenerName,
            "--event" => $eventName,
            "--queued" => $queued
        ];
        \Artisan::call("larapi:make:listener", $options);
    }

    public static function createJob(string $moduleName, string $jobName, bool $sync = false)
    {
        $options = [
            "module" => $moduleName,
            "name" => $jobName,
            "--sync" => $sync
        ];
        \Artisan::call("larapi:make:job", $options);
    }

    public static function createCommand(string $moduleName, string $jobName, string $commandName = null)
    {
        $options = [
            "module" => $moduleName,
            "name" => $jobName,
            "--command" => $commandName
        ];
        \Artisan::call("larapi:make:command", $options);
    }
}