<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <title>Book Library</title>
</head>
<body>
    <x-app-layout>
        <section class="p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2  ">Title</th>
                        <th class="px-4 py-2">Author</th>
                        <th class="px-4 py-2">View</th>
                    </tr>
                </thead>
                <tbody class="bg-red">
                    @foreach($books as $book)   
                    <tr class="bg-white hover:bg-gray-100 transition">
                        <td class="px-4 py-2 text-xl">{{ $book->title }}</td>
                        <td class="px-4 py-2">{{ $book->author }}</td>
                        <td class="px-4 py-2 flex gap-10">
                            <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:underline text-xl ">View book</a>
    </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </x-app-layout>
</body>
</html>
  