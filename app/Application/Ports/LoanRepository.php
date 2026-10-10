<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by application, implemented by an adapter. */
interface LoanRepository
{
    /**
     * Saves loan and items and decrements stock in the SAME transaction.
     * If another concurrent transaction took the last copy, throws BOOK_NOT_AVAILABLE (RNF-2).
     */
    public function add(Loan $loan): void;

    public function get(string $id): ?Loan;

    /**
     * Q7: active unreturned items summary for member.
     * @return array{open:int, overdue:int}
     */
    public function openItemsSummary(string $memberId, DateTimeImmutable $now): array;

    /** Marks return and restocks 1 copy; throws ITEM_ALREADY_RETURNED if already returned. */
    public function returnItem(string $loanId, string $itemId, string $bookId, DateTimeImmutable $returnedAt): void;
}
