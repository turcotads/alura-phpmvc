<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Controller\InterfaceControladorRequisicao;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Infra\EntityManagerCreator;

class Persistencia implements InterfaceControladorRequisicao
{
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())
            ->getEntityManager();
    }
    public function processaRequisicao(): void
    {
        $descricao = $_POST['descricao'];

        $curso = new Curso();
        $curso->setDescricao($descricao);

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!is_null($id) && $id !== false) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
        } else {
            $this->entityManager->persist($curso);
        }

        $this->entityManager->flush();

        header('Location: /listar-cursos', true, 302);
    }
}
