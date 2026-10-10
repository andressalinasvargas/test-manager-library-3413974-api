<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by the application, implemented by an adapter. */
interface PasswordHasher
{
    public function hash(string $plain): string;

    public function verify(string $plain, string $hash): bool;
}
