<?php

namespace App\Controller;


use App\Entity\Prefix;
use App\Entity\Sequencer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SequencerController extends AbstractController
{

    /**
     * @Route("/", name="homepage" )
     */
    public function homepage()
    {
        return $this->render('index.html.twig');

    }



    /**
     * @Route("/getSequence", name="get_sequence" )
     */
    public function getSequence()
    {

        //$last_sequence = $this->getDoctrine()->getRepository(Sequencer::class)->findOneBy(array(),array('id'=>'DESC'),0,1);

        //return $this->render('getSequence.html.twig', ["last_id"=> $last_sequence->getId()]);
        return $this->render('getSequence.html.twig');
    }


    /**
     * @Route("/getSequence/generate", name="generate_sequence", methods={"POST"} )
     */
    public function generateSequence()
    {
        //Get the manager
        $em = $this->getDoctrine()->getManager();
        $objSeq = new Sequencer();
        $objSeq
            ->setUsername($this->getUser()->getUsername())
            ->setUsername($this->getUser()->getUsername())
            ->setAgency($this->getUser()->getAgency())
            ->setCreatetime(new \DateTime());

        $em->persist($objSeq);
        $em->flush();

        //Get the prefix from 'Prefix' table
        $prefixResult = $this->getDoctrine()->getRepository(Prefix::class)->findOneBy(array(),array('id'=>'DESC'),0,1);
        $prefixAndSeq = $prefixResult->getPrefix().sprintf('%06d', $objSeq->getId());
        //Update the sequence fiedl with number on 6 digits
        $objSeq->setSequence($prefixAndSeq);

        $em->persist($objSeq);
        $em->flush();

        //Return the new ID to the form
        return new JsonResponse(['new_sequence' => $prefixAndSeq]);
    }

    /**
     * @Route("/allSequences", name="all_sequences" )
     */
    public function allSequences()
    {

        return $this->render('allSequences.html.twig');
    }


    /**
     * @Route("/mySequences", name="my_sequences" )
     */
    public function mySequences()
    {

        return $this->render('mySequences.html.twig');
    }


    /**
     * @Route("/reserve", name="reserve_sequence")
     */
    public function reserve()
    {


        $em = $this->getDoctrine()->getManager();
        $objSeq = new Sequencer();
        $objSeq
            ->setUsername($this->getUser()->getUsername())
            ->setUsername($this->getUser()->getUsername())
            ->setAgency($this->getUser()->getAgency())
            ->setCreatetime(new \DateTime());

        $em->persist($objSeq);
        $em->flush();

        return new Response("Saved task with id " . $objSeq->getId());
        //Todo update the sequence field after confirmation with a prefix+ID

    }

}