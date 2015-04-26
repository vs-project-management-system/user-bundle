<?php
namespace PMS\Bundle\UserBundle\Entity;

use \PMS\Bundle\ProjectBundle\Traits\HasProjectsTrait;

class Developer extends \PMS\Bundle\UserBundle\Entity\User
{
    use HasProjectsTrait;
    
    /**
     * Team
     * @var \PMs\Bundle\UserBundle\Entity\Team
     */
    protected $team;
    
    /**
     * Get team
     * @return \PMS\Bundle\UserBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }
    
    /**
     * Set team
     * @param \PMS\Bundle\UserBundle\Entity\Team $team
     * @return \PMS\Bundle\UserBundle\Entity\Client
     */
    public function setTeam(\PMS\Bundle\UserBundle\Entity\Team $team)
    {
        $this->team = $team;
        
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
