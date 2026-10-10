<?php

namespace App\Application\Services;

use App\Application\Ports\IdGenerator;
use App\Application\Ports\PasswordHasher;
use App\Application\Ports\UserRepository;
use App\Domain\User;

/**
 * HU-02: Register librarian users (admin).
 * CA-02.1: role librarian.
 * CA-02.2: username lowercase and trimmed; unique (409 USERNAME_TAKEN).
 * CA-02.3: requesting admin via API responds 422; password is never returned.
 */
final class CreateLibrarianService
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly PasswordHasher $hasher,
        private readonly IdGenerator $ids,
    ) {}

    /**
     * @return array{id:string, username:string, role:string}
     */
    public function execute(string $username, string $plainPassword, string $requestedRole): array
    {
        $id = $this->ids->next();
        $passwordHash = $this->hasher->hash($plainPassword);
        $user = User::createLibrarian($id, $username, $passwordHash, $requestedRole);

        $this->users->add($user);

        return [
            'id'       => $user->id,
            'username' => $user->username,
            'role'     => $user->role,
        ];
    }
}

