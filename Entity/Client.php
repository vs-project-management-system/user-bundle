<?php
namespace PMS\Bundle\UserBundle\Entity;

use \PMS\Bundle\ProjectBundle\Traits\HasProjectsTrait;

class Client extends \PMS\Bundle\UserBundle\Entity\User
{
    use HasProjectsTrait;
    
    /**
     * Organization
     * @var \PMs\Bundle\UserBundle\Entity\Organization
     */
    protected $organization;
    
    /**
     * Get organization
     * @return \PMS\Bundle\UserBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }
    
    /**
     * Set organization
     * @param \PMS\Bundle\UserBundle\Entity\Organization $organization
     * @return \PMS\Bundle\UserBundle\Entity\Client
     */
    public function setOrganization(\PMS\Bundle\UserBundle\Entity\Organization $organization)
    {
        $this->organization = $organization;
        
        return $this;
    }
    
    /**
     * Construct
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
