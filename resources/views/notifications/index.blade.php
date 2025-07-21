<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Support Messages</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>
<body class="bg-gray-100">

<header class="bg-white shadow-md w-full">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logonew2.png') }}" alt="Logo" class="h-12">
        </div>

        <nav class="hidden md:flex space-x-4 items-center">
        <a href="{{ route('dashboard') }}"
           class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-900 text-sm">
          Dashboard
        </a>
      </nav>
    </div>
</header>

<main class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">All Support Messages</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="mb-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded">
            {{ session('warning') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table id="notificationTable" class="min-w-full border bg-white rounded shadow">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Issue Type</th>
                    <th class="px-4 py-2 border">Message</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                    <tr class="{{ $msg->is_read ? '' : 'bg-yellow-50' }}">
                        <td class="px-4 py-2 border">{{ $msg->name }}</td>
                        <td class="px-4 py-2 border">{{ $msg->email }}</td>
                        <td class="px-4 py-2 border">{{ $msg->issue_type }}</td>
                        <td class="px-4 py-2 border">{{ $msg->message }}</td>
                        <td class="px-4 py-2 border">
                            <span class="{{ $msg->is_read ? 'text-green-600' : 'text-red-600 font-semibold' }}">
                                {{ $msg->is_read ? 'Read' : 'Unread' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            @if(!$msg->is_read)
                                <form method="POST" action="{{ route('notifications.markRead', $msg->id) }}">
                                    @csrf
                                    <button type="submit" class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        ✅ Mark as Read
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">Read</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#notificationTable').DataTable({
            paging: false, // Pagination handled by Laravel
            searching: true,
            ordering: true,
            info: false
        });
    });
</script>

</body>
</html>
