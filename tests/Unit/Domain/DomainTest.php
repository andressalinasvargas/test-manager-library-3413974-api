<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\Book;
use App\Domain\DomainError;
use App\Domain\Isbn;
use App\Domain\Quantity;
use App\Domain\DateRange;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for non-negotiable domain invariants (T-03, T-04, T-05).
 * Domain is evaluated without framework, without database, and without network (Article I).
 */
class DomainTest extends TestCase
{
    public function test_valid_isbn_is_accepted(): void
    {
        $isbn = new Isbn('9781234567890');
        $this->assertSame('9781234567890', $isbn->value());
    }

    public function test_invalid_isbn_throws_domain_error(): void
    {
        $this->expectException(DomainError::class);
        new Isbn('invalid-isbn');
    }

    public function test_quantity_cannot_be_negative(): void
    {
        $this->expectException(DomainError::class);
        new Quantity(-1);
    }

    public function test_date_range_requires_start_before_or_equal_to_end(): void
    {
        $start = new DateTimeImmutable('2026-10-10');
        $end = new DateTimeImmutable('2026-10-24');
        $range = new DateRange($start, $end);
        $this->assertTrue($range->start() <= $range->end());
    }

    public function test_book_stock_withdrawal_and_restock(): void
    {
        $book = new Book(
            id: '11111111-1111-4111-8111-111111111111',
            title: 'Don Quijote de la Mancha',
            author: 'Miguel de Cervantes',
            isbn: new Isbn('9780123456789'),
            categoryId: 'e1b1a1a1-0001-4000-8000-000000000001',
            totalCopies: new Quantity(5),
            availableCopies: new Quantity(5),
            coverKey: null,
            deletedAt: null
        );

        $withdrawn = $book->withdraw();
        $this->assertSame(4, $withdrawn->availableCopies()->value());

        $restocked = $withdrawn->restock();
        $this->assertSame(5, $restocked->availableCopies()->value());
    }

    public function test_book_cannot_withdraw_when_out_of_stock(): void
    {
        $book = new Book(
            id: '11111111-1111-4111-8111-111111111111',
            title: 'Clean Architecture',
            author: 'Robert C. Martin',
            isbn: new Isbn('9780123456789'),
            categoryId: 'e1b1a1a1-0003-4000-8000-000000000003',
            totalCopies: new Quantity(1),
            availableCopies: new Quantity(0),
            coverKey: null,
            deletedAt: null
        );

        $this->expectException(DomainError::class);
        $book->withdraw();
    }
}

