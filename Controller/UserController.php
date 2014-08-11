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
 * @Route("/users")
 */
class UserController extends \PMS\Bundle\CoreBundle\Controller\Controller
{
    /**
     * @Route("/", name="pms_user_index")
     * @Template("PMSUserBundle:User:index.html.twig")
     */
    public function indexAction()
    {
        $this->breadcrumbs->addItem('users');
        
        $query = $this->get('doctrine')
                          ->getRepository('PMSUserBundle:User')
                          ->createQueryBuilder('p')
                          ->orderBy('p.updated, p.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'users' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="pms_user_new")
     * @Template("PMSUserBundle:User:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->breadcrumbs->addItem('users', $this->get('router')->generate('pms_user_index'));
        
        $user = new \PMS\Bundle\UserBundle\Entity\User();
        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\UserFormType(),
            $user
        );

        if ("POST" === $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'user created.'
                );

                return $this->render(
                    'PMSUserBundle:User:show.html.twig',
                    array(
                        'user' => $user
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{slug}/edit", name="pms_user_edit")
     * @Template("PMSUserBundle:User:new.html.twig")
     */
    public function editAction($slug)
    {
        $this->breadcrumbs->addItem(
            'users',
            $this->get('router')
                 ->generate('pms_user_edit', array('slug' => $slug))
        );
        
        $user = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:User')
                        ->findOneBySlug($slug);

        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\UserFormType(),
            $user
        );

        if (!$user) {
            $this->get('session')
                 ->getFlashBag()
                 ->add(
                     'error',
                     'could not find matching user.'
                 );
            $this->forward('pms_user_index');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/search/{query}", name="pms_user_search_q")
     * @Route("/search", name="pms_user_search")
     * @Template("PMSUserBundle:User:search.html.twig")
     */
    public function searchAction($query = null)
    {
        $form = $this->createForm(new \PMS\Bundle\UserBundle\Form\Type\UserSearchFormType());

        if ("POST" == $this-getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $users = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:User')
                        ->search($query);

                return $this->render(
                    'PMSUserBundle:User:index.html.twig',
                    array(
                        'users' => $users
                    )
                );
            }
        }

        return array('form' => $form);
    }

    /**
     * @Route("/{slug}", name="pms_user_show")
     * @Template("PMSUserBundle:User:show.html.twig")
     */
    public function showAction($slug)
    {
        $user = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:User')
                        ->findOneBySlug($slug);

        if (!$user) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching user found.'
            );
            $this->redirect(
                $this->generateUrl('pms_user_index')
            );
        }

        return array('user' => $user);
    }
}
