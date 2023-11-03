<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class UserController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('booksUser.index', compact('books'));
        // return view('books.index', [
        //     'books'=> Book::all()
        // ]);
    }

    public function pickBook(Book $book)
    {
        if ($book->isAvailable) {
            $book->isAvailable = false;
            $book->picked_at = now();
            $book->save();

            // Schedule a task to make the book available again in 7 days
            $this->scheduleBookAvailableTask($book);
        }

        return redirect()->route('books.index')
            ->with('success', 'Book picked successfully');
    }

    private function scheduleBookAvailableTask(Book $book)
    {
        // Schedule a task to make the book available again after 7 days
        Artisan::call('schedule:bookAvailable', ['book_id' => $book->id])->output();
    }

    public function store(Request $request)
    {

        $book = new Book;

        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->isAvailable = $request->isAvailable == "on" ? true : false;

        $book->save();

        return redirect()->route('books.index', ['book' => $book])
            ->with('success', 'Book created successfully');
    }

}
