<?php
namepspace PMS\Bundle\UserBundle\Traits;

trait SluggableTrait
{
    /**
     * Slug
     * @var string
     */
    protected $slug;

    /**
     * Get slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     */
    public function setSlug($slug = null)
    {
        if (null == $slug) {
            $this->slug = str_replace(
                ' ',
                '-',
                $this->getName()
            );
        }

        return $this;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->firstName.' '.$this->lastName;
    }
}