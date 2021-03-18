<?php

namespace App\Controller;

use App\Entity\Snowflake;
use App\Form\SnowflakeType;
use App\Repository\SnowflakeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnowController extends AbstractController
{
    /**
     * @Route("/random", name="app_random")
     */
    public function random(): Response
    {
        $number = random_int(0, 100);
        // dd($number); //? Signifie dump and die, donc fais un dumping de mon instruction et "tue" le script.

        return $this->render('snow/random.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(SnowflakeRepository $snowflakeRepository): Response
    {
        $snowflakes = $snowflakeRepository->findAll();

        // dd($snowflakes);

        return $this->render('snow/index.html.twig', [
            'snowflakes' => $snowflakes,
        ]);
    }

    /**
     * @Route("/snowflake/{id}",name="app_snowflake_show", requirements={"id"="\d+"})
     */
    public function show(Snowflake $snowflake): Response
    {
        // $snowflake = $snowflakeRepository->findOneBy(['id' => $id]);

        // dd($snowflake);

        return $this->render('snow/details.html.twig', [
            'snowflake' => $snowflake,
        ]);
    }

    /**
     * @Route("/snowflake/new", name="app_snowflake_new", methods="GET|POST")
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $snowflake = new Snowflake();
        $form = $this->createForm(SnowflakeType::class, $snowflake);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($snowflake);
            $manager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('snow/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/snowflake/edit/{id<\d+>}", name="app_snowflake_edit")
     */
    public function edit(Request $request, EntityManagerInterface $manager, Snowflake $snowflake): Response
    {
        $form = $this->createForm(SnowflakeType::class, $snowflake);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('snow/edit.html.twig', [
            'form' => $form->createView(),
            // 'snowflake' => $snowflake,
        ]);
    }

    /**
     * @Route("/snowflake/delete/{id<\d+>}",name="app_snowflake_delete", methods="DELETE")
     */
    public function delete(Request $request, EntityManagerInterface $manager, Snowflake $snowflake)
    {
        if (
            $this->isCsrfTokenValid(
                'snowflake_deletion_'.$snowflake->getId(),
                $request->request->get('csrf_token')
            )
            ) {
            $manager->remove($snowflake);
            $manager->flush();

            $this->addFlash('success', 'Your snowflake has been deleted successfully');
        }

        return $this->redirectToRoute('app_index');
    }
}
