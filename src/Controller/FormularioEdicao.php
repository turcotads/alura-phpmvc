<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioEdicao implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait;

    private $repositorioCurso;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioCurso = $entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (is_null($id) || $id === false) {
            // header('Location: /listar-cursos');
            return new Response(200, ['Location' => '/listar-cursos']);
        }

        /** @var Curso $curso */
        $curso = $this->repositorioCurso->find($id);

        return new Response(200, [], $this->renderizaHtml('cursos/formulario.php', [
            'curso' => $curso,
            'titulo' => 'Alterar curso: ' . $curso->getDescricao()
        ]));
    }
}
