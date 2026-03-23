<?php

declare(strict_types=1);

namespace Genauchat\Typo3Plugin\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Registry;

class ScriptInjector implements MiddlewareInterface
{
    public function __construct(
        private readonly Registry $registry
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (!(bool)$this->registry->get('genauchat', 'enabled', true)) {
            return $response;
        }

        $script = $this->registry->get('genauchat', 'widget_script', '');

        if (
            empty(trim($script))
            || !str_contains($script, 'genau.chat')
            || !str_contains($script, '<script')
        ) {
            return $response;
        }

        $contentType = $response->getHeaderLine('Content-Type');
        if (!str_contains($contentType, 'text/html')) {
            return $response;
        }

        $body = (string)$response->getBody();
        if (!str_contains($body, '</body>')) {
            return $response;
        }

        $modifiedBody = str_replace('</body>', "\n" . trim($script) . "\n</body>", $body);

        $stream = new Stream('php://temp', 'r+');
        $stream->write($modifiedBody);
        $stream->rewind();

        return $response->withBody($stream);
    }
}
