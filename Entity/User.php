<?php
namespace PMS\Bundle\UserBundle\Entity;

use \PMS\Bundle\CoreBundle\Traits\TimestampableTrait;
use \PMS\Bundle\UserBundle\Traits\SluggableTrait;

class User extends \FOS\UserBundle\Model\User
{
    use TimestampableTrait;
    use SluggableTraits;
    
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * First name
     * @var string
     */
    protected $firstName;

    /**
     * Last name
     * @var string 
     */
    protected $lastName;

    /**
     * Gender
     * @var string
     */
    protected $gender;

    /**
     * Birthdate
     * @var \DateTime 
     */
    protected $birthdate;

    /**
     * Facebook id
     * @var string
     */
    protected $facebookId;

    /**
     * Google id
     * @var string 
     */
    protected $googleId;

    /**
     * Linked in
     * @var string 
     */
    protected $linkedinId;

    /**
     * Twitter id
     * @var string
     */
    protected $twitterId;

    /**
     * Foursquare id
     * @var string
     */
    protected $foursquareId;

    /**
     * Avatar
     * @var sytring
     */
    protected $avatar;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->avatar = '/bundles/PMSuser/img/avatars/default.png';
    }

    /**
     * Get full name
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastname();
    }

    /**
     * Set facebook id
     * @param string $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
        $this->salt = '';
    }

    /**
     * Get facebook id
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set FB data
     * @param array $fbdata
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstName($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastName($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }

    /**
     * Set firstname
     * @param string $firstname
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setFirstName($firstname)
    {
        $this->firstName = $firstname;

        return $this;
    }

    /**
     * Get firstname
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastname
     * @param string $lastname
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setLastName($lastname)
    {
        $this->lastName = $lastname;

        return $this;
    }

    /**
     * Get lastname
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set google id
     * @param string $googleId
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get google id
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set linkedin
     * @param string $linkedinId
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setLinkedinId($linkedinId)
    {
        $this->linkedinId = $linkedinId;

        return $this;
    }

    /**
     * Get linkedin
     * @return string
     */
    public function getLinkedinId()
    {
        return $this->linkedinId;
    }

    /**
     * Set twitter id
     * @param string $twitterId
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;

        return $this;
    }

    /**
     * Get twitter id
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * Set foursquare id
     * @param string $foursquareId
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setFoursquareId($foursquareId)
    {
        $this->foursquareId = $foursquareId;

        return $this;
    }

    /**
     * Get foursquare id
     * @return string
     */
    public function getFoursquareId()
    {
        return $this->foursquareId;
    }

    /**
     * Set avatar
     * @param string $avatar
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getUrl()
    {
        return $this->url;
    }
   
    /**
     * Set gender
     * @param string $gender
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setGender($gender)
    {
        if (in_array(strtolower($gender), ['m', 'f'])) {
            $this->gender = $gender;
        }        
    
        return $this;
    }

    /**
     * Get gender
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthdate
     * @param \DateTime $birthdate
     * @return \PMS\Bundle\UserBundle\Entity\User
     */
    public function setBirthdate(\DateTime $birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }
}
