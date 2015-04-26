<?php
namespace PMS\Bundle\UserBundle\Entity;

class Admin extends \PMS\Bundle\UserBundle\Entity\User
{
    /**
     * Primary
     * @var boolean
     */
    protected $primary;
    
    /**
     * Is primary
     * @param boolean|null $primary
     * @return \PMS\Bundle\UserBundle\Entity\Admin|boolean
     */
    public function isPrimary($primary = null)
    {
         if (null != $primary) {
            $this->primary = (boolean) $primary;
            
            return $this;
        }
        
        return $this->primary;
    }
    
    /**
     * Get primary
     * @return boolean
     */
    public function getPrimary()
    {
        return $this->primary;
    }
    
    /**
     * Set primary
     * @param boolean $primary
     * @return \PMS\Bundle\UserBundle\Entity\Admin
     */
    public function setPrimary(boolean $primary)
    {
        $this->primary = $primary;
        
        return $this;
    }
}
