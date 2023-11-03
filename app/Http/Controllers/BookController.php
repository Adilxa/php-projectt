<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
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

    // ... (other methods)

    public function makeBookAvailable()
    {
        $unavailableBooks = Book::where('isAvailable', false)->get();

        foreach ($unavailableBooks as $book) {
            $pickedAt = $book->picked_at;
            $sevenDaysAgo = Carbon::now()->subDays(7);

            if ($pickedAt && $pickedAt <= $sevenDaysAgo) {
                $book->isAvailable = true;
                $book->picked_at = null;
                $book->save();
            }
        }

        return "Books updated";
    }

    public function create()
    {
        return view('books.create');
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

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }
    public function update(Request $request, Book $book)
    {

        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->description = $request->input('description');
        $book->isAvailable = $request->input('isAvailable', true); // Default to true if not provided
        $book->save();
    
        return redirect()->route('books.index', ['book' => $book])
            ->with('success', 'Book updated successfully');
    }
    

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
