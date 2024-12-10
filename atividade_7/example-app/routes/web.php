    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthorController;
    use App\Http\Controllers\BookController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\PublisherController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\BorrowingController;

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('users', UserController::class)->except(['create', 'store', 'destroy']);
   
    
    Route::get('/books/create/id', [BookController::class, 'createWithId'])->name('books.create.id');
    Route::get('/books/create/select', [BookController::class, 'createWithSelect'])->name('books.create.select');
    Route::post('/books/store/id', [BookController::class, 'storeWithId'])->name('books.store.id');
    Route::post('/books/store/select', [BookController::class, 'storeWithSelect'])->name('books.store.select');

    // Rota para registrar um empréstimo
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('books.borrow');

    // Rota para listar o histórico de empréstimos de um usuário
    Route::get('/users/{user}/borrowings', [BorrowingController::class, 'userBorrowings'])->name('users.borrowings');

    // Rota para registrar a devolução
    Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    // Agora as rotas RESTful para books
    Route::resource('books', BookController::class)->except(['create', 'store']);





