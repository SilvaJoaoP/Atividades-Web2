<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Exibir livros com paginação
    public function index()
    {
        // Carregar os livros com autores usando eager loading e paginação
        $books = Book::with('author')->paginate(20);

        return view('books.index', compact('books'));
    }

    // Exibir detalhes de um livro
    public function show(Book $book)
    {
        // Carregar autor, editora e categoria do livro com eager loading
        $book->load(['author', 'publisher', 'category']);

        // Carregar todos os usuários para o formulário de empréstimo
        $users = User::all();

        return view('books.show', compact('book', 'users'));
    }

    // Método para editar um livro
    public function edit(Book $book)
    {
        // Carregar editoras, autores e categorias para o formulário de edição
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
    }

    // Método para exibir o formulário de criação com ID
    public function createWithId()
    { 
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create-id', compact('publishers', 'authors', 'categories'));
    }

    // Método para exibir o formulário de criação com SELECT
    public function createWithSelect()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    // Salvar livro com input de ID
    public function storeWithId(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação de imagem
        ]);

        // Processar o upload da imagem
        $coverImagePath = $request->file('cover_image') 
            ? $request->file('cover_image')->store('cover_images', 'public') 
            : null;

        // Criar o livro com a imagem da capa
        Book::create(array_merge(
            $request->all(),
            ['cover_image' => $coverImagePath]
        ));

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Salvar livro com input select
    public function storeWithSelect(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação para imagem
        ]);

        // Verificar se foi enviado um arquivo de imagem e salvar
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('cover_images', 'public'); // Salva a imagem na pasta public/cover_images
        } else {
            $path = 'cover_images/default_cover.jpg'; // Caminho para uma imagem padrão
        }

        // Criar o livro com a imagem de capa
        Book::create([
            'title' => $request->input('title'),
            'author_id' => $request->input('author_id'),
            'category_id' => $request->input('category_id'),
            'publisher_id' => $request->input('publisher_id'),
            'cover_image' => $path, // Armazena o caminho da imagem
        ]);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Atualizar livro
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação para imagem
        ]);

        // Verificar se foi enviado um novo arquivo de imagem e salvar
        if ($request->hasFile('cover_image')) {
            // Excluir a imagem antiga se houver
            if ($book->cover_image && file_exists(storage_path('app/public/' . $book->cover_image))) {
                unlink(storage_path('app/public/' . $book->cover_image));
            }
            
            $path = $request->file('cover_image')->store('cover_images', 'public'); // Salva a nova imagem
        } else {
            $path = $book->cover_image; // Mantém a imagem existente
        }

        // Atualizar o livro
        $book->update([
            'title' => $request->input('title'),
            'author_id' => $request->input('author_id'),
            'category_id' => $request->input('category_id'),
            'publisher_id' => $request->input('publisher_id'),
            'cover_image' => $path, // Armazena o caminho da imagem
        ]);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }

    // Deletar livro
    public function destroy(Book $book)
    {
        // Deletar a imagem da capa, se existir
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro deletado com sucesso.');
    }
}

