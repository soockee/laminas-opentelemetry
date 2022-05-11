<?php

declare(strict_types=1);

namespace Soockee\OpenTelemetryModule;

use ErrorException;
use Laminas\Mvc\MvcEvent;

use OpenTelemetry\SDK\Trace\SpanExporter\ConsoleSpanExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;



class Module
{
    public function getConfig(): array
    {
        $provider = new ConfigProvider();
        $config = $provider();
        $config['service_manager'] = $provider->getDependencies();
        unset($config['dependencies']);

        return $config;
    }
    public function onBootstrap(MvcEvent $e): void
    {
        $application = $e->getApplication();
        $container = $application->getServiceManager();

        /** @var array<string, mixed> $appConfig */
        $appConfig = $container->get('config');

        if (($appConfig['opentelemetry']['disable_module'] ?? false)) {
            return;
        }
        if (($appConfig['opentelemetry']['test'] ?? false)) {
            echo $appConfig['opentelemetry']['test'];
        }

        $this->initOpentelemetry();
    }

    public function initOpentelemetry(){
        $tracerProvider =  new TracerProvider(
            new SimpleSpanProcessor(
                new ConsoleSpanExporter()
            )
        );
        $tracer = $tracerProvider->getTracer();

        $rootSpan = $tracer->spanBuilder('root')->startSpan();
        $rootSpan->activate();

        try {
            $span1 = $tracer->spanBuilder('foo')->startSpan();
            $span1->activate();

            try {
                $span2 = $tracer->spanBuilder('bar')->startSpan();
                echo 'OpenTelemetry welcomes PHP' . PHP_EOL;
            } finally {
                $span2->end();
            }
        } finally {
            $span1->end();
        }
        $rootSpan->end();
    }
}
