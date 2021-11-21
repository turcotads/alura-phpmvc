<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RealizarLogin implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $repositorioDeUsuarios;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeUsuarios = $entityManager->getRepository(Usuario::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if (is_null($email) or $email === false) {
            $this->defineMensagem('danger', "E-mail inválido");
            return new Response(200, ['Location' => '/login']);
        }

        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        /** @var Usuario $usuario */
        $usuario = $this->repositorioDeUsuarios->findOneBy([
            'email' => $email
        ]);


        if (is_null($usuario) or !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem('danger', "E-mail ou senha inválidos");
            return new Response(200, ['Location' => '/login']);
        }

        $_SESSION['logado'] = true;

        return new Response(200, ['Location' => '/listar-cursos']);
    }
}
