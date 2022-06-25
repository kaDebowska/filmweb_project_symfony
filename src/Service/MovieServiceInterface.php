<?php
/**
 * Movie service interface.
 */

namespace App\Service;

use App\Entity\Movie;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface MovieServiceInterface.
 */
interface MovieServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     *
     * @throws NonUniqueResultException
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface;

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     *
     * @throws NonUniqueResultException
     */
    public function prepareFilters(array $filters): array;

    /**
     * Save entity.
     *
     * @param Movie $movie Task entity
     */
    public function save(Movie $movie): void;

    /**
     * Delete entity.
     *
     * @param Movie $movie Task entity
     */
    public function delete(Movie $movie): void;
}
