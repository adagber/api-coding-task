<?php declare(strict_types=1);

namespace App\bootstrap\DI;

use App\Lotr\Infrastructure\Validator\ValidatorInterface;
use App\Security\AuthenticatorInterface;
use App\Lotr\Infrastructure\Validator\Validator as AppValidator;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Symfony\Component\Validator\Validation;
use UMA\DIC\ServiceProvider;

/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself that wires everything together.
 */
final class Slim implements ServiceProvider
{

    /**
     * {@inheritdoc}
     */
    public function provide(ContainerInterface $container): void
    {
        $container->set(App::class, static function (ContainerInterface $container): App {

            /** @var array $settings */
            $settings = $container->get('settings');

            $app = AppFactory::createFromContainer($container);

            $app->addBodyParsingMiddleware();
            $app->addRoutingMiddleware();
            $app->addErrorMiddleware(
                $settings['slim']['displayErrorDetails'],
                $settings['slim']['logErrors'],
                $settings['slim']['logErrorDetails']
            );

            return $app;
        });

        $container->set(ValidatorInterface::class, static function (ContainerInterface $container): ValidatorInterface
        {
            /** @var array $settings */
            $settings = $container->get('settings');

            $symfonyValidator = Validation::createValidatorBuilder()
                ->addYamlMappings($settings['validator']['paths'])
                ->getValidator()
            ;

            return new AppValidator($symfonyValidator);
        });
    }
}