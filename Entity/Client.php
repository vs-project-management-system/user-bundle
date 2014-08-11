<?php
namespace PMS\Bundle\UserBundle\Entity;

use \PMS\Bundle\ProjectBundle\Traits\HasProjectsTrait;

class Client extends \PMS\Bundle\UserBundle\Entity\User
{
    use HasProjectsTrait;
}
