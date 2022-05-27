<?php
/**
 * Movie controller.
 */

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovieController.
 */
#[Route('/movie')]
class MovieController extends AbstractController
{
    /**
     * Index action.
     *
     * @param MovieRepository $movieRepository Movie repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'movie_index',
        methods: 'GET'
    )]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render(
            'movie/index.html.twig',
            ['movies' => $movies]
        );
    }

    /**
     * Show action.
     *
     * @param Movie $movie Movie entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'movie_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Movie $movie): Response
    {
        return $this->render(
            'movie/show.html.twig',
            ['movie' => $movie]
        );
    }
}
