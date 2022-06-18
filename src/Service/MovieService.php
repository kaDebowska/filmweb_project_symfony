<?php
/**
 * Movie service.
 */

namespace App\Service;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\NonUniqueResultException;
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
     * Category service.
     */
    private CategoryServiceInterface $categoryService;


    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     * @param MovieRepository    $movieRepository Movie repository
     * @param PaginatorInterface $paginator       Paginator
     */
    public function __construct(
        CategoryServiceInterface $categoryService,
        PaginatorInterface $paginator,
        MovieRepository $movieRepository
    ) {
        $this->categoryService = $categoryService;
        $this->paginator = $paginator;
        $this->movieRepository = $movieRepository;
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     * @throws NonUniqueResultException
     */
    public function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }
        return $resultFilters;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     * @throws NonUniqueResultException
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->movieRepository->queryAll($filters),
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
