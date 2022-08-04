<?php
declare(strict_types=1);

namespace Kelnik\Repository;

use Kelnik\Database\QueryResult;
use Kelnik\Entity\GuestBook;
use Kelnik\Exception\Repository\GuestBookRepositoryException;

class GuestBookRepository extends BaseMysqlRepository implements GuestBookRepositoryInterface
{
    public function getTableName(): string
    {
        return 'guest_book';
    }

    public function save(GuestBook $guestBook): QueryResult
    {
        $isNew = (bool)$guestBook->getId();
        $sql = sprintf('insert into %s (', $this->getTableName());

        if ($isNew) {
            $sql .= 'id, ';
        }

        $sql .= 'dtime, name, email, body) VALUES (';

        if ($isNew) {
            $sql .= sprintf('%s, ', $this->prepareValue($guestBook->getId()));
        }

        $sql .= sprintf(
            "'%s', '%s', '%s', '%s')",
            $this->prepareValue($guestBook->getDateCreate()->format(static::DATABASE_DATE_FORMAT)),
            $this->prepareValue($guestBook->getName()),
            $this->prepareValue($guestBook->getEmail()),
            $this->prepareValue($guestBook->getBody()),
        );

        return $this->query($sql);
    }

    public function findNewRecords(int $limit = 5): \Generator
    {
        $sql = sprintf(
            'select * from %s order by dtime desc limit %s',
            $this->getTableName(),
            $limit
        );

        $result = $this->query($sql);

        if (!$result->isSuccess()) {
            throw new GuestBookRepositoryException('Some errors while find new records');
        }

        $data = $result->getData();

        foreach ($data as $entityData) {
            yield $this->makeEntityFromArray($entityData);
        }
    }

    private function makeEntityFromArray(array $entity): GuestBook
    {
        $dateCreate = \DateTime::createFromFormat('Y-m-d H:i:s', $entity['dtime']);

        if (!$dateCreate) {
            throw new GuestBookRepositoryException(sprintf('Invalid date format: %s', $entity['dtime']));
        }

        return new GuestBook(
            (int)$entity['id'] ?: null,
            $dateCreate,
            $entity['name'],
            $entity['email'],
            $entity['body'],
        );
    }
}
