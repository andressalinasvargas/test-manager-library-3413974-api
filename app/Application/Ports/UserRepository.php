<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by the application, implemented by an adapter. */
interface UserRepository
{
    public function findByUsername(string $normalizedUsername): ?User;

    /** Throws USERNAME_TAKEN if the storage engine rejects a duplicate. */
    public function add(User $user): void;
}
