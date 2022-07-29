<?php
declare(strict_types=1);

namespace Kelnik\Repository;

use Kelnik\Database\QueryResult;
use Kelnik\Entity\GuestBook;

interface GuestBookRepositoryInterface
{
    public function save(GuestBook $guestBook): QueryResult;
    public function findNewRecords(int $limit = 5): \Generator;
}