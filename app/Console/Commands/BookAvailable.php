<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Carbon\Carbon;

class BookAvailable extends Command
{
    protected $signature = 'schedule:bookAvailable {book_id?}';
    protected $description = 'Make books available again after 7 days of being picked';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $bookId = $this->argument('book_id');

        if ($bookId) {
            // If a specific book ID is provided, you can make that book available here.
            $book = Book::find($bookId);
            // Implement the logic to make this book available again.
        } else {
            // If no book ID is provided, make books available after 7 days.
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
            $this->info('Books made available after 7 days.');
        }
    }
}
