<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Borrowing;

class BorrowingPolicy
{
    /**
     * Determina se o usuário pode visualizar qualquer empréstimo.
     */
    public function viewAny(User $user)
    {
        // Apenas admin e bibliotecario podem visualizar a lista de empréstimos
        return $user->role === 'admin' || $user->role === 'bibliotecario';
    }

    /**
     * Determina se o usuário pode visualizar um empréstimo específico.
     */
    public function view(User $user, Borrowing $borrowing)
    {
        // Apenas admin, bibliotecario ou o próprio usuário podem visualizar um empréstimo específico
        return $user->role === 'admin' || $user->role === 'bibliotecario' || $user->id === $borrowing->user_id;
    }

    /**
     * Determina se o usuário pode criar empréstimos.
     */
    public function create(User $user)
    {
        // Apenas admin e bibliotecario podem criar empréstimos
        return $user->role === 'admin' || $user->role === 'bibliotecario';
    }

    /**
     * Determina se o usuário pode atualizar um empréstimo.
     */
    public function update(User $user, Borrowing $borrowing)
    {
        // Apenas admin e bibliotecario podem atualizar empréstimos
        return $user->role === 'admin' || $user->role === 'bibliotecario';
    }

    /**
     * Determina se o usuário pode excluir um empréstimo.
     */
    public function delete(User $user, Borrowing $borrowing)
    {
        // Apenas admin pode excluir empréstimos
        return $user->role === 'admin';
    }

}