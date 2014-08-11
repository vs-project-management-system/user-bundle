<?php
namespace PMS\Bundle\ProjectBundle\Form\Type;

class ProjectSearchFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(
        \Symfony\Component\Form\FormBuilderInterface $builder,
        array $options
    ) {
        $builder->add(
            'query',
            'search'
        );
        
        $builder->add(
            'status',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\ProjectBundle\Entity\Status'
            )
        );
        
        $builder->add(
            'category',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\ProjectBundle\Entity\Category'
            )
        );
        
        $builder->add(
            'client',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\UserBundle\Entity\Client'
            )
        );
    }

    public function getName()
    {
        return 'project_search';
    }
}
