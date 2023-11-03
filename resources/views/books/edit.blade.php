<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <title>Edit Book</title>
</head>
<body>
    <x-app-layout>
        <div class="container mx-auto p-6">
            <h1 class="text-3xl font-bold mb-4">Edit Book</h1>
            <form action="{{ route('books.update', $book) }}" method="post" class="bg-white p-4 shadow-md rounded-md">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="text-gray-600 block">Title</label>
                    <input type="text" name="title" value="{{ $book->title }}" required class="w-full p-2 border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="author" class="text-gray-600 block">Author</label>
                    <input type="text" name="author" value="{{ $book->author }}" required class="w-full p-2 border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="description" class="text-gray-600 block">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded-md">{{ $book->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="isAvailable" class="text-gray-600 block">Is Available</label>
                    <input type="checkbox" name="isAvailable" {{ $book->isAvailable ? 'checked' : '' }} class="p-2 rounded-md">
                </div>
                <button type="submit" class="bg-blue-500 text-black transition p-2 rounded-md hover:bg-blue-600 hover:text-white">Update</button>
            </form>
        </div>
    </x-app-layout>
</body>
</html>
