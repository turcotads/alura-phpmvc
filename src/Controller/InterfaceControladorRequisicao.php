<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface InterfaceControladorRequisicao
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface;
}
