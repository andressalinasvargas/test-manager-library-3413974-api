<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by application, implemented by an adapter. */
interface MemberRepository
{
    public function get(string $id): ?Member;

    /** Locks member row inside transaction to serialize loans. */
    public function getForUpdate(string $id): ?Member;

    /** Throws DOCUMENT_TAKEN if database engine rejects duplicate. */
    public function add(Member $member): void;

    public function search(?string $q, int $page, int $size): Page;

    /** Count of active unreturned items for member. */
    public function activeLoansCount(string $memberId): int;
}
