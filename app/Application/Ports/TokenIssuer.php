<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by the application, implemented by an adapter. */
interface TokenIssuer
{
    /** @return array{access_token:string, expires_in:int} */
    public function issue(string $userId, string $role): array;

    /** @return array{sub:string, role:string}|null */
    public function verify(string $token): ?array;
}
