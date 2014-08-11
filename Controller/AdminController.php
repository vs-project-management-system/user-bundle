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
 * @Route("/admins")
 */
class AdminController extends \PMS\Bundle\CoreBundle\Controller\Controller
{
    /**
     * @Route("/", name="pms_admin_index")
     * @Template("PMSUserBundle:Admin:index.html.twig")
     */
    public function indexAction()
    {
        $this->breadcrumbs->addItem('admins');
        
        $query = $this->get('doctrine')
                          ->getRepository('PMSUserBundle:Admin')
                          ->createQueryBuilder('p')
                          ->orderBy('p.updated, p.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'admins' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="pms_admin_new")
     * @Template("PMSUserBundle:Admin:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->breadcrumbs->addItem('admins', $this->get('router')->generate('pms_admin_index'));
        
        $admin = new \PMS\Bundle\UserBundle\Entity\Admin();
        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\AdminFormType(),
            $admin
        );

        if ("POST" === $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($admin);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'admin created.'
                );

                return $this->render(
                    'PMSUserBundle:Admin:show.html.twig',
                    array(
                        'admin' => $admin
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{slug}/edit", name="pms_admin_edit")
     * @Template("PMSUserBundle:Admin:new.html.twig")
     */
    public function editAction($slug)
    {
        $this->breadcrumbs->addItem(
            'admins',
            $this->get('router')
                 ->generate('pms_admin_edit', array('slug' => $slug))
        );
        
        $admin = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Admin')
                        ->findOneBySlug($slug);

        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\AdminFormType(),
            $admin
        );

        if (!$admin) {
            $this->get('session')
                 ->getFlashBag()
                 ->add(
                     'error',
                     'could not find matching admin.'
                 );
            $this->forward('pms_admin_index');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/search/{query}", name="pms_admin_search_q")
     * @Route("/search", name="pms_admin_search")
     * @Template("PMSUserBundle:Admin:search.html.twig")
     */
    public function searchAction($query = null)
    {
        $form = $this->createForm(new \PMS\Bundle\UserBundle\Form\Type\AdminSearchFormType());

        if ("POST" == $this-getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $admins = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Admin')
                        ->search($query);

                return $this->render(
                    'PMSUserBundle:Admin:index.html.twig',
                    array(
                        'admins' => $admins
                    )
                );
            }
        }

        return array('form' => $form);
    }

    /**
     * @Route("/{slug}", name="pms_admin_show")
     * @Template("PMSUserBundle:Admin:show.html.twig")
     */
    public function showAction($slug)
    {
        $admin = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Admin')
                        ->findOneBySlug($slug);

        if (!$admin) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching admin found.'
            );
            $this->redirect(
                $this->generateUrl('pms_admin_index')
            );
        }

        return array('admin' => $admin);
    }
}
