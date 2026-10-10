<?php

namespace App\Application\Services;

use App\Application\Ports\PasswordHasher;
use App\Application\Ports\TokenIssuer;
use App\Application\Ports\UserRepository;
use App\Domain\DomainError;
use App\Domain\User;

/**
 * HU-01: User login.
 * CA-01.1: 8 hours validity (28800 s).
 * CA-01.2: invalid credentials returns 401 without revealing whether username or password failed.
 */
final class LoginService
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly PasswordHasher $hasher,
        private readonly TokenIssuer $tokens,
    ) {}

    /**
     * @return array{access_token:string, token_type:string, expires_in:int, role:string}
     */
    public function execute(string $rawUsername, string $password): array
    {
        $normalized = User::normalizeUsername($rawUsername);
        $user = $this->users->findByUsername($normalized);

        if ($user === null || ! $this->hasher->verify($password, $user->passwordHash)) {
            throw new DomainError(
                DomainError::INVALID_CREDENTIALS,
                'Credenciales inválidas.',
            );
        }

        $issued = $this->tokens->issue($user->id, $user->role);

        return [
            'access_token' => $issued['access_token'],
            'token_type'   => 'Bearer',
            'expires_in'   => $issued['expires_in'],
            'role'         => $user->role,
        ];
    }
}

