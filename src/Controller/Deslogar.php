<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class Deslogar implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        session_destroy();
        return new Response(200, ['Location' => '/login']);
    }
}
