<?php

namespace Alexstericris\AlecrisAiApis\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Alexstericris\AlecrisAiApis\ExamplePackage
 */
class ExamplePackage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Alexstericris\AlecrisAiApis\ExamplePackage::class;
    }
}
