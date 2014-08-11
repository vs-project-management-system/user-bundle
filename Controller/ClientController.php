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
 * @Route("/clients")
 */
class ClientController extends \PMS\Bundle\CoreBundle\Controller\Controller
{
    /**
     * @Route("/", name="pms_client_index")
     * @Template("PMSUserBundle:Client:index.html.twig")
     */
    public function indexAction()
    {
        $this->breadcrumbs->addItem('clients');
        
        $query = $this->get('doctrine')
                          ->getRepository('PMSUserBundle:Client')
                          ->createQueryBuilder('p')
                          ->orderBy('p.updated, p.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'clients' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="pms_client_new")
     * @Template("PMSUserBundle:Client:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->breadcrumbs->addItem('clients', $this->get('router')->generate('pms_client_index'));
        
        $client = new \PMS\Bundle\UserBundle\Entity\Client();
        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\ClientFormType(),
            $client
        );

        if ("POST" === $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($client);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'client created.'
                );

                return $this->render(
                    'PMSUserBundle:Client:show.html.twig',
                    array(
                        'client' => $client
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{slug}/edit", name="pms_client_edit")
     * @Template("PMSUserBundle:Client:new.html.twig")
     */
    public function editAction($slug)
    {
        $this->breadcrumbs->addItem(
            'clients',
            $this->get('router')
                 ->generate('pms_client_edit', array('slug' => $slug))
        );
        
        $client = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Client')
                        ->findOneBySlug($slug);

        $form = $this->createForm(
            new \PMS\Bundle\UserBundle\Form\Type\ClientFormType(),
            $client
        );

        if (!$client) {
            $this->get('session')
                 ->getFlashBag()
                 ->add(
                     'error',
                     'could not find matching client.'
                 );
            $this->forward('pms_client_index');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/search/{query}", name="pms_client_search_q")
     * @Route("/search", name="pms_client_search")
     * @Template("PMSUserBundle:Client:search.html.twig")
     */
    public function searchAction($query = null)
    {
        $form = $this->createForm(new \PMS\Bundle\UserBundle\Form\Type\ClientSearchFormType());

        if ("POST" == $this-getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $clients = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Client')
                        ->search($query);

                return $this->render(
                    'PMSUserBundle:Client:index.html.twig',
                    array(
                        'clients' => $clients
                    )
                );
            }
        }

        return array('form' => $form);
    }

    /**
     * @Route("/{slug}", name="pms_client_show")
     * @Template("PMSUserBundle:Client:show.html.twig")
     */
    public function showAction($slug)
    {
        $client = $this->getDoctrine()
                        ->getRepository('PMSUserBundle:Client')
                        ->findOneBySlug($slug);

        if (!$client) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching client found.'
            );
            $this->redirect(
                $this->generateUrl('pms_client_index')
            );
        }

        return array('client' => $client);
    }
}
