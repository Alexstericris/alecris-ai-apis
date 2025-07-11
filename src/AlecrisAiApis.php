<?php

namespace Alexstericris\AlecrisAiApis;

use Alexstericris\AlecrisAiApis\Commands\ExamplePackageCommand;
use Alexstericris\AlecrisAiApis\Services\GeminiService;
use Alexstericris\AlecrisAiApis\Services\ApiResponseParser;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AlecrisAiApis extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('alecris-ai-apis')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_example_package_table')
            ->hasCommand(ExamplePackageCommand::class);
    }

    public function packageRegistered()
    {
        $this->app->bind(GeminiService::class, function ($app, $params) {
            return new GeminiService(config('alecris-ai-apis.gemini.key'), systemPrompts: [
                'contents' => [
                    [
                        "role" => "user",
                        "parts" => [
                            [
                                "text" => "Style html elements with tailwind 4 classes. For example, style a blue button."
                            ]
                        ]
                    ],
                    [
                        "role" => "model",
                        "parts" => [
                            [
                                "text" => 'Ok, here is your styled button:
                                ```html
                                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Default</button>
                                ```
                                '
                            ]
                        ]
                    ],
                ]
            ]);
        });
    }
}
