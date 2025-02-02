@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuário</h1>

    @can('update', $user)
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Campo de Role (apenas admin pode editar) -->
            @can('edit-role', $user)
                <div class="mb-3">
                    <label for="role" class="form-label">Papel</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="bibliotecario" {{ $user->role === 'bibliotecario' ? 'selected' : '' }}>Bibliotecário</option>
                        <option value="cliente" {{ $user->role === 'cliente' ? 'selected' : '' }}>Cliente</option>
                    </select>
                </div>
            @endcan

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    @else
        <div class="alert alert-danger" role="alert">
            Você não tem permissão para editar usuários.
        </div>
    @endcan
</div>
@endsection