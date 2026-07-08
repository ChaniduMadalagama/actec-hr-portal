<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function find(int $id): ?User;
    public function findByUsername(string $username): ?User;
    public function getTechniciansWithLiveStatus(): Collection;
}
