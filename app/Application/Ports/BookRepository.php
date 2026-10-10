<?php

namespace App\Application\Ports;

use App\Application\Page;
use App\Domain\Book;
use App\Domain\Loan;
use App\Domain\Member;
use App\Domain\User;
use DateTimeImmutable;

/** Output port (Article II): defined by application, implemented by an adapter. */
interface BookRepository
{
    /** Active only (deleted_at IS NULL). */
    public function getActive(string $id): ?Book;

    /** Includes deleted books (for returns of historical books). */
    public function getAny(string $id): ?Book;

    /**
     * Q3: active books by batch.
     * @param list<string> $ids
     * @return array<string, Book>
     */
    public function getManyActive(array $ids): array;

    /** Throws ISBN_TAKEN if partial index rejects duplicate. */
    public function add(Book $book): void;

    /** Replaces editable data; adjusts available copies atomically. */
    public function replace(Book $book): void;

    public function markDeleted(Book $book): void;

    public function setCover(string $bookId, ?string $coverKey): void;

    public function hasOpenLoans(string $bookId): bool;

    /** Q1: partial text search on title/author, category, active only, ordered by title. */
    public function search(?string $q, ?string $categoryId, int $page, int $size): Page;
}
