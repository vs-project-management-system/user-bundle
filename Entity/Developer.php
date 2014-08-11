<?php
namespace PMS\Bundle\UserBundle\Entity;

use \PMS\Bundle\ProjectBundle\Traits\HasProjectsTrait;

class Developer extends \PMS\Bundle\UserBundle\Entity\User
{
    use HasProjectsTrait;
}
