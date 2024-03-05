<?php

namespace Z7\Lalalytics\Middleware;

use GuzzleHttp\Exception\TransferException;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProxyForward implements MiddlewareInterface
{
    public function __construct(
        protected ResponseFactoryInterface $responseFactory
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (str_starts_with($request->getUri()->getPath(), '/_lala/ingest')) {
            $site = $request->getAttribute('site');
            $context = GeneralUtility::makeInstance(Context::class);
            $currentLanguageId = $context->getPropertyFromAspect('language', 'id');
            $config = $site->getLanguageById($currentLanguageId)->toArray();

            if ((bool) ($config['lalalytics_proxy'] ?? false)) {
                if ((bool) ($config['lalalytics_filterip'] ?? false)) {
                    $id = md5($_SERVER['HTTP_HOST'] . '-' . $_SERVER['REMOTE_ADDR'] . '-' . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
                    $_SERVER['HTTP_X_FORWARDED_FOR'] = $id;
                }

                $_SERVER['REQUEST_URI'] = str_replace('_lala/', '', $_SERVER['REQUEST_URI']);
                $serverRequest = ServerRequestFactory::fromGlobals();
                $target = new Uri('https://i.lalalytics.com');
                $uri = $serverRequest->getUri()
                    ->withScheme($target->getScheme())
                    ->withHost($target->getHost())
                    ->withPort($target->getPort());
                $forwardRequest = $serverRequest->withUri($uri)->withoutHeader('cookie');

                try {
                    return (new \GuzzleHttp\Client())->send($forwardRequest)
                        ->withoutHeader('transfer-encoding')
                        ->withoutHeader('content-encoding');
                } catch (TransferException $e) {
                    return $e->getResponse();
                }
            }
        }
        return $handler->handle($request);
    }
}
