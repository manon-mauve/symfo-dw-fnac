<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Album;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AchatController extends AbstractController
{
    #[Route('/achat/{id_album}', name: 'app_achat')]
    public function app_achat(int $id_album, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $album = $em->getRepository(Album::class)->find($id_album);
        if (!$album) {
            throw $this->createNotFoundException(
                'No album found for id '.$id_album
            );
        }
        $achat = new Achat();
        $achat->setUser($user);
        $achat->setAlbum($album);
        $achat->setCreatedAt(new \DateTimeImmutable());
        $em->persist($achat);
        $em->flush();
        return $this->redirectToRoute('app_album_index');
    }
}

