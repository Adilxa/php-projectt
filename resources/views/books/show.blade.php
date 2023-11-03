<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <title>Book Details</title>
</head>
<body>
    <x-app-layout >
        <div class="flex justify-center items-center w-screen-full h-full ">
            <div class="p-6 ">
                <h1 class="text-3xl font-bold">TITLE: {{ $book->title }}</h1>
                <p class="text-lg text-gray-700">Author: {{ $book->author }}</p>
                <p class="mt-2 text-gray-800"> Description: {{ $book->description }}</p>
                <p class="mt-2 text-gray-800">Available: 
                    <span class="{{ $book->isAvailable ? 'text-green-600' : 'text-red-600' }}">
                        {{ $book->isAvailable ? 'Yes' : 'No' }}
                    </span>
                </p>
                <a href="{{ route('books.edit', $book) }}" class="mt-4 text-blue-500 hover:underline">Edit</a>
            </div>
        </div>
    </x-app-layout>
</body>
</html>
