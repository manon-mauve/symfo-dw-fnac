<?php

namespace App\Entity;

use App\Repository\MusiqueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MusiqueRepository::class)]
#[Vich\Uploadable] 
class Musique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy:'musiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    #[Vich\UploadableField(mapping: 'songs', fileNameProperty: 'songName')]
    private ?File $songFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $songName = null;

    public function setSongFile(?File $songFile = null): void
    {
        $this->songFile = $songFile;
    }

    public function getSongFile(): ?File
    {
        return $this->songFile;
    }

    public function setSongName(?string $songName): void
    {
        $this->songName = $songName;
    }

    public function getSongName(): ?string
    {
        return $this->songName;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }
}
