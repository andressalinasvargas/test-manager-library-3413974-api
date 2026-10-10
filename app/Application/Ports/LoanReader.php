<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by application, implemented by an adapter. */
interface LoanReader
{
    /** Q6: loans by date range, status and member, ordered by loaned_at descending. */
    public function list(?DateTimeImmutable $from, ?DateTimeImmutable $toExclusive, ?string $status, ?string $memberId, DateTimeImmutable $now, int $page, int $size): Page;

    /** Q8: overdue line items, most delayed first. */
    public function overdue(DateTimeImmutable $now, int $page, int $size): Page;
}
