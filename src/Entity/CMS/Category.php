<?php

namespace App\Entity\CMS;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LAG\AdminBundle\Metadata\AdminResource;
use LAG\AdminBundle\Metadata\Create;
use LAG\AdminBundle\Metadata\Delete;
use LAG\AdminBundle\Metadata\Index;
use LAG\AdminBundle\Metadata\Update;

#[ORM\Entity]
#[AdminResource(
    name: 'cms_category',
    prefix: '/categories',
    operations: [
        new Index(),
        new Create(),
        new Update(),
        new Delete(),
    ],
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\Column(type: 'string')]
    public string $name;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true)]
    public ?Category $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    /** @var Collection<Category> $children */
    public Collection $children;

    #[ORM\Column(type: 'string')]
    public string $publicationStatus = 'draft';

    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category')]
    /** @var Collection<Article> $articles */
    public Collection $articles;

    #[ORM\Column(type: 'string')]
    public string $slug;

    #[ORM\Column(type: 'boolean')]
    public bool $displayInHomepage = false;

    #[ORM\Column(type: 'string', nullable: true)]
    public ?string $description = null;

    #[ORM\Column(type: 'date_immutable')]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'date_immutable')]
    public \DateTimeImmutable $updatedAt;

    //public $thumbnail;
}
