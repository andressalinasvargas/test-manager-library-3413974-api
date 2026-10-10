<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by the application, implemented by an adapter. */
interface CoverStorage
{
    public function put(string $key, string $bytes): void;

    public function get(string $key): ?string;

    public function delete(string $key): void;
}
