<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Book Library</title>
</head>
<body>
    <x-app-layout>
        <section class="p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Author</th>
                        <th class="px-4 py-2">View</th>
                    </tr>
                </thead>
                <tbody class="bg-red">
                    @foreach($books as $book)   
                    <tr class="bg-white hover:bg-gray-100 transition">
                        <td class="px-4 py-2 text-xl">{{ $book->title }}</td>
                        <td class="px-4 py-2">{{ $book->author }}</td>
                        <td class="px-4 py-2 flex gap-10 items-center">
                            <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:underline text-xl">View book</a>
                            <a href="#" class="text-blue-gray hover:underline text-xl bg-green-500 p-2 rounded transition text-white" data-toggle="modal" data-target="#bookModal" data-book-id="{{ $book->id }}" data-title="{{ $book->title }}">Get the book</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </x-app-layout>

    <!-- Modal HTML -->
    <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Book Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="duration">Select Duration (1-7 days):</label>
                    <input type="range" id="duration" name="duration" min="1" max="7" value="1" class="form-control-range">
                    <span id="selectedDuration">1 day</span>
                    @foreach($books as $book)   
                    <tr class="bg-white hover:bg-gray-100 transition">
                        <td class="px-4 py-2 text-xl">{{ $book->id }}</td>
                    </tr>
                    @endforeach
                </div>
                <input type="" id="bookId" name="bookId">
                <div class="modal-footer">
                    <button type="button" class="btn text-black" data-dismiss="modal">Close</button>
                    <button type="button" class="btn text-black" id="saveDurationBtn">Save Duration</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to update the selected duration text -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
 $(document).ready(function () {
        $('#saveDurationBtn').on('click', function () {
            var selectedValue = $('#duration').val();
            var bookId = $('#bookId').val();

            jQuery.ajax({
                type: 'POST',
                url: '{{ route("books.save-duration", ["book" => ":bookId"]) }}'.replace(':bookId', bookId),
                data: {
                    _token: '{{ csrf_token() }}',
                    duration: selectedValue,
                },
                success: function (response) {
                    alert(response.message); // You can handle the response from the server
                    $('#bookModal').modal('hide'); // Close the modal if needed
                },
                error: function (error) {
                    console.error('Error saving duration:', error);
                },
            });
        });

        $('#bookModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var title = button.data('title');
            var modal = $(this);
            modal.find('#bookModalLabel').text('Book Details: ' + title);
            modal.find('#bookId').val(button.data('book-id'));
            // Update selected duration text based on the range input value
            $('#duration').on('input', function () {
                var selectedValue = $(this).val();
                var durationText = selectedValue == 1 ? 'day' : 'days';
                modal.find('#selectedDuration').text(selectedValue + ' ' + durationText);
            });
        });
    });
    </script>
</body>
</html>
