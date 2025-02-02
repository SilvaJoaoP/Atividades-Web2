<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Author;

class AuthorPolicy
{
    /**
     * Determina se o usuário pode visualizar qualquer autor.
     */
    public function viewAny(User $user)
    {
        // Todos os usuários podem visualizar a lista de autores
        return true;
    }

    /**
     * Determina se o usuário pode visualizar um autor específico.
     */
    public function view(User $user, Author $author)
    {
        // Todos os usuários podem visualizar um autor específico
        return true;
    }

    /**
     * Determina se o usuário pode criar autores.
     */
    public function create(User $user)
    {
        // Apenas admin e bibliotecario podem criar autores
        return $user->role === 'admin' || $user->role === 'bibliotecario';
    }

    /**
     * Determina se o usuário pode atualizar um autor.
     */
    public function update(User $user, Author $author)
    {
        // Apenas admin e bibliotecario podem atualizar autores
        return $user->role === 'admin' || $user->role === 'bibliotecario';
    }

    /**
     * Determina se o usuário pode excluir um autor.
     */
    public function delete(User $user, Author $author)
    {
        // Apenas admin pode excluir autores
        return $user->role === 'admin';
    }
}