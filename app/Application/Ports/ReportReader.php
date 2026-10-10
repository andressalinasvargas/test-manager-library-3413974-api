<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by application, implemented by an adapter. */
interface ReportReader
{
    /**
     * Q9 / ADR-004: one row per frozen book_id + book_title + category_name.
     * @return list<array{book_id:string, book_title:string, category_name:string, times_borrowed:int}>
     */
    public function mostBorrowed(DateTimeImmutable $fromInclusive, DateTimeImmutable $toExclusive): array;
}
