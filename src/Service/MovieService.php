<?php
/**
 * Movie service.
 */

namespace App\Service;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class MovieService.
 */
class MovieService implements MovieServiceInterface
{
    /**
     * Movie repository.
     */
    private MovieRepository $movieRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param MovieRepository    $movieRepository Movie repository
     * @param PaginatorInterface $paginator       Paginator
     */
    public function __construct(MovieRepository $movieRepository, PaginatorInterface $paginator)
    {
        $this->movieRepository = $movieRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->movieRepository->queryAll(),
            $page,
            MovieRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Movie $movie Task entity
     */
    public function save(Movie $movie): void
    {
        $this->movieRepository->save($movie);
    }

    /**
     * Delete entity.
     *
     * @param Movie $movie Task entity
     */
    public function delete(Movie $movie): void
    {
        $this->movieRepository->delete($movie);
    }
}
