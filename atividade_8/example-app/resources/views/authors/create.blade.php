@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Adicionar Autor</h1>

    @can('create', App\Models\Author::class)
        <form action="{{ route('authors.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Salvar
            </button>
            <a href="{{ route('authors.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </form>
    @else
        <div class="alert alert-danger" role="alert">
            Você não tem permissão para criar autores.
        </div>
    @endcan
</div>
@endsection