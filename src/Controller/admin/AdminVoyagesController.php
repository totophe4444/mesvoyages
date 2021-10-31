<?php

namespace App\Controller\admin;

use App\Entity\Visite;
use App\Form\VisiteType;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminVoyagesController
 *
 * @author tophe
 */
class AdminVoyagesController extends AbstractController {
    /**
     *
     * @var EntityManagerInterface 
     */
    private $om;
    /**
     *
     * @var VisiteRepository 
     */
    private $repository;
    function __construct(VisiteRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }

    /**
     * @Route("/admin", name="admin.voyages")
     * @return Response
     */
    public function index(): Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("admin/admin.voyages.html.twig",[
            'visites' => $visites
        ]);
    } 
    /**
     * @Route("/admin/suppr/{id}", name="admin.voyages.suppr")
     * @param Visite $visite
     * @return Response
     */
    public function suppr(Visite $visite): Response {
        $this->om->remove($visite);
         $this->om->flush();
        return $this->redirectToRoute('admin.voyages');
    } 
    /**
     * @Route("/admin/edit/{id}", name="admin.voyage.edit")
     * @param Visite $visite
     * @param Request $request
     * @return Response
     */
    public function edit(Visite $visite, Request $request): Response {
        $formVisite = $this->createForm(VisiteType::class, $visite);
        
        $formVisite->handleRequest($request);
        if($formVisite->isSubmitted() && $formVisite->isValid()){
            $this->om->flush();
            return $this->redirectToRoute('admin.voyages');
        }
        
        return $this->render("admin/admin.voyage.edit.html.twig",[
            'visite' => $visite,
            'formvisite' => $formVisite->createView()
        ]);
    } 
}
