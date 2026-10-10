<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by the application, implemented by an adapter. */
interface CategoryRepository
{
    /** @return array{id:string, name:string}|null */
    public function find(string $id): ?array;

    /** @return list<array{id:string, name:string}> sorted by name */
    public function all(): array;
}
