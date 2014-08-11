<?php
namespace PMS\Bundle\UserBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use \Gedmo\Mapping\Annotation as Gedmo;
use \Symfony\Component\Validator\Constraints as Assert;
use \PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="\PMS\Bundle\UserBundle\Repository\AdminRepository")
 * @ORM\Table(name="admin")
 * @UniqueEntity(fields = "username", targetClass = "PMS\Bundle\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "PMS\Bundle\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Admin extends \PMS\Bundle\UserBundle\Entity\User
{
}
