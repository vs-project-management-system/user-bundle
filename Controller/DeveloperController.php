<?php
namespace PMS\Bundle\UserBundle\Controller;

use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Request;

use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;
use \Pagerfanta\Exception\NotValidCurrentPageException;
use \Pagerfanta\View\TwitterBootstrapView;

/**
 * @Route("/developers")
 */
class DeveloperController extends \PMS\Bundle\CoreBundle\Controller\Controller
{
    /**
     * @Route("/", name="pms_developer_index")
     * @Template("PMSUserBundle:Developer:index.html.twig")
     */
    public function indexAction()
    {
        $this->breadcrumbs->addItem('developers');
        
        $query = $this->get('doctrine')
                          ->getRepository('PMSUserBundle:Developer')
                          ->createQueryBuilder('p')
                          ->orderBy('p.updated, p.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'developers' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="pms_developer_new")
     * @Template("PMSUserBundle:Developer:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->breadcrumbs->addItem('developers', $this->get('router')->generate('pms_developer_index'));
        
        $developer = new \PMS\Bundle\UserBundle\Entity\Developer();
        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\DeveloperFormType(),
            $developer
        );

        if ("POST" === $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($developer);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'developer created.'
                );

                return $this->render(
                    'PMSUserBundle:Developer:show.html.twig',
                    array(
                        'developer' => $developer
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{slug}/edit", name="pms_developer_edit")
     * @Template("PMSUserBundle:Developer:new.html.twig")
     */
    public function editAction($slug)
    {
        $this->breadcrumbs->addItem(
            'developers',
            $this->get('router')
                 ->generate('pms_developer_edit', array('slug' => $slug))
        );
        
        $developer = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Developer')
                        ->findOneBySlug($slug);

        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\DeveloperFormType(),
            $developer
        );

        if (!$developer) {
            $this->get('session')
                 ->getFlashBag()
                 ->add(
                     'error',
                     'could not find matching developer.'
                 );
            $this->forward('pms_developer_index');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/search/{query}", name="pms_developer_search_q")
     * @Route("/search", name="pms_developer_search")
     * @Template("PMSUserBundle:Developer:search.html.twig")
     */
    public function searchAction($query = null)
    {
        $form = $this->createForm(new \PMS\Bundle\UserBundle\Form\Type\DeveloperSearchFormType());

        if ("POST" == $this-getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $developers = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Developer')
                        ->search($query);

                return $this->render(
                    'PMSUserBundle:Developer:index.html.twig',
                    array(
                        'developers' => $developers
                    )
                );
            }
        }

        return array('form' => $form);
    }

    /**
     * @Route("/{slug}", name="pms_developer_show")
     * @Template("PMSUserBundle:Developer:show.html.twig")
     */
    public function showAction($slug)
    {
        $developer = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Developer')
                        ->findOneBySlug($slug);

        if (!$developer) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching developer found.'
            );
            $this->redirect(
                $this->generateUrl('pms_developer_index')
            );
        }

        return array('developer' => $developer);
    }
}
