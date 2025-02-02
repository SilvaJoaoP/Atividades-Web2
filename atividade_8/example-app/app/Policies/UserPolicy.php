<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determina se o usuário pode visualizar qualquer usuário.
     */
    public function viewAny(User $user)
    {
        // Apenas admin pode visualizar a lista de usuários
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode visualizar um usuário específico.
     */
    public function view(User $user, User $model)
    {
        // Apenas admin pode visualizar outros usuários
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode criar usuários.
     */
    public function create(User $user)
    {
        // Apenas admin pode criar usuários
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode atualizar um usuário.
     */
    public function update(User $user, User $model)
    {
        // Apenas admin pode atualizar usuários
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode excluir um usuário.
     */
    public function delete(User $user, User $model)
    {
        // Apenas admin pode excluir usuários
        return $user->role === 'admin';
    }
}