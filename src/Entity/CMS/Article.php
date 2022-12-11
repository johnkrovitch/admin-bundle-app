<?php

namespace App\Entity\CMS;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use LAG\AdminBundle\Metadata\AdminResource;

#[ORM\Entity]
#[AdminResource]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\Column(type: 'string')]
    public string $title;

    #[ORM\Column(type: 'string', nullable: true)]
    public ?string $canonical = null;

    #[ORM\Column(type: 'string')]
    public string $publicationStatus = 'draft';

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    public DateTimeImmutable $publicationDate;

    #[ORM\Column(type: 'text')]
    public string $content = '';

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\Category", inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'articles', fetch: 'EAGER')]
    public Category $category;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="JK\CmsBundle\Entity\User", inversedBy="articles")
     */
    protected $author;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="JK\CmsBundle\Entity\Comment", mappedBy="article")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $comments;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_commentable", type="boolean")
     */
    protected $isCommentable = true;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @var Tag[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="JK\CmsBundle\Entity\Tag", mappedBy="articles", cascade={"persist", "remove"})
     */
    protected $tags;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var MediaInterface
     *
     * @ORM\ManyToOne(targetEntity="JK\MediaBundle\Entity\Media", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $thumbnail;
}
