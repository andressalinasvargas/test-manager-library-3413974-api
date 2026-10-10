<?php

namespace App\Domain;

/**
 * Business error with canonical error code (api-contract.md §2).
 * Domain and application layers only throw this; the HTTP adapter maps it to status and unified JSON body.
 */
final class DomainError extends \RuntimeException
{
    public const NOT_FOUND = 'NOT_FOUND';
    public const VALIDATION_ERROR = 'VALIDATION_ERROR';
    public const INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
    public const FORBIDDEN_ROLE = 'FORBIDDEN_ROLE';
    public const FORBIDDEN = 'FORBIDDEN';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';
    public const UNAUTHORIZED = 'UNAUTHORIZED';
    public const USERNAME_TAKEN = 'USERNAME_TAKEN';
    public const USERNAME_NOT_UNIQUE = 'USERNAME_NOT_UNIQUE';
    public const ISBN_TAKEN = 'ISBN_TAKEN';
    public const ISBN_NOT_UNIQUE = 'ISBN_NOT_UNIQUE';
    public const ISBN_ALREADY_EXISTS = 'ISBN_ALREADY_EXISTS';
    public const DOCUMENT_TAKEN = 'DOCUMENT_TAKEN';
    public const MEMBER_DOCUMENT_NOT_UNIQUE = 'MEMBER_DOCUMENT_NOT_UNIQUE';
    public const BOOK_HAS_OPEN_LOANS = 'BOOK_HAS_OPEN_LOANS';
    public const BOOK_NOT_AVAILABLE = 'BOOK_NOT_AVAILABLE';
    public const BOOK_OUT_OF_STOCK = 'BOOK_OUT_OF_STOCK';
    public const BOOK_NOT_FOUND = 'BOOK_NOT_FOUND';
    public const MEMBER_NOT_FOUND = 'MEMBER_NOT_FOUND';
    public const LOAN_NOT_FOUND = 'LOAN_NOT_FOUND';
    public const ITEM_NOT_FOUND = 'ITEM_NOT_FOUND';
    public const MEMBER_HAS_OVERDUE = 'MEMBER_HAS_OVERDUE';
    public const MEMBER_HAS_OVERDUE_LOANS = 'MEMBER_HAS_OVERDUE_LOANS';
    public const ITEM_ALREADY_RETURNED = 'ITEM_ALREADY_RETURNED';
    public const MEMBER_LIMIT_EXCEEDED = 'MEMBER_LIMIT_EXCEEDED';
    public const DUPLICATE_BOOK_IN_LOAN = 'DUPLICATE_BOOK_IN_LOAN';
    public const INVALID_DATE_RANGE = 'INVALID_DATE_RANGE';

    /** @param list<array{field:string, issue:string}> $details */
    public function __construct(
        public readonly string $errorCode,
        string $message,
        public readonly array $details = [],
    ) {
        parent::__construct($message);
    }

    public static function notFound(string $message = 'El recurso no existe.'): self
    {
        return new self(self::NOT_FOUND, $message);
    }

    public static function validation(string $message, string $field = '', string $issue = ''): self
    {
        $details = $field !== '' ? [['field' => $field, 'issue' => $issue !== '' ? $issue : $message]] : [];

        return new self(self::VALIDATION_ERROR, $message, $details);
    }
}

