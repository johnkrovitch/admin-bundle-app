<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use LAG\AdminBundle\Metadata\AdminResource;

#[ORM\Entity]
#[AdminResource]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\Column('name')]
    public string $name;
}
