<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/player/create', name: 'app_player_create')]
    public function save(Request $request,EntityManagerInterface $entityManager): Response
    {
        $pv = $request->request->get('pv'); 
        $name = $request->request->get('name');
        $mana = $request->request->get('mana');
        $ap = $request->request->get('ap');
        $ad = $request->request->get('ad');

        $player = new Player();
        $player->setName($name);
        $player->setAd($ad);
        $player->setAp($ap);
        $player->setPv($pv);
        $player->setMana($mana);
        $entityManager->persist($player);
        $entityManager->flush();


        return $this->redirectToRoute('app_player_show',['id' => $player->getId()]);
    }

    #[Route('/player/show/{id}', name: 'app_player_show')]
    public function show(Player $player){
        return $this->render('player/index2.html.twig', [
            'player' => $player,
        ]);
    }

    #[Route('/player/delete/{id}', name: 'app_player_delete')]
    public function delete(EntityManagerInterface $entityManager,Player $player){
        $entityManager->remove($player);
        $entityManager->flush();
        return $this->redirectToRoute('app_player_show_all');
    }

    #[Route('/player/all', name: 'app_player_show_all')]
    public function showAll(EntityManagerInterface $entityManager){
        $players = $entityManager->getRepository(Player::class)->findAll();
        return $this->render('player/index.html.twig',['players' => $players]);
    }
    #[Route('/formulaire', name: 'app_player_form')]
    public function form(EntityManagerInterface $entityManager){
        return $this->render('player/createformulaire.html.twig');
    }
    #[Route('/player/edit/{id}', name: 'app_player_edit_form', methods: ['GET'])]
    public function update_form(EntityManagerInterface $entityManager, int $id){
        $player = $entityManager->getRepository(Player::class)->find($id);
        return $this->render('player/index.html.twig', ['player' => $player]);
    }
    #[Route('/player/edit/{id}', name: 'app_player_edit',methods: ['POST'])]
    public function update(Request $request,EntityManagerInterface $entityManager, int $id){

        $player = $entityManager->getRepository(Player::class)->find($id);
        $player->setName($request->request->get('name'));
        $player->setAd($request->request->get('ad'));
        $player->setAp($request->request->get('ap'));
        $player->setPv($request->request->get('pv'));
        $player->setMana($request->request->get('mana'));
        $entityManager->flush();

        return $this->redirectToRoute('app_player_show_all');
    }
}
