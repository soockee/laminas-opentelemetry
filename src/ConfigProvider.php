<?php

declare(strict_types=1);

namespace Soockee\OpenTelemetryModule;

final class ConfigProvider
{
    /**
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'opentelemetry' => [
                'disable_module' => false,
                'test' => 'hello, World!',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getDependencies(): array
    {
        return [

        ];
    }
}
