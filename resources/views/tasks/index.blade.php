<!DOCTYPE html>
<html>
<head>
    <title>Task App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow mb-6">
        <div class="max-w-xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="font-bold text-lg">Task App</span>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="text-sm text-red-500 hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Task Manager</h1>

        <!-- Add Task -->
        <form method="POST" action="/tasks" class="flex gap-2 mb-4">
            @csrf
            <input type="text" name="title"
                class="border p-2 flex-1 rounded"
                placeholder="New Task" required>
            <button class="bg-blue-500 text-white px-4 rounded">
                Add
            </button>
        </form>

        <!-- Task List -->
        @foreach($tasks as $task)
        <div class="mb-2 p-2 border rounded">

            {{-- Normal view --}}
            <div class="flex items-center justify-between" id="view-{{ $task->id }}">

                <form method="POST" action="/tasks/{{ $task->id }}/toggle">
                    @csrf
                    @method('PATCH')
                    <button class="mr-2">
                        {{ $task->is_done ? '✔' : '❌' }}
                    </button>
                </form>

                <span class="flex-1 {{ $task->is_done ? 'line-through text-gray-400' : '' }}">
                    {{ $task->title }}
                </span>

                <div class="flex gap-2 ml-4">
                    <button
                        onclick="showEdit({{ $task->id }}, '{{ addslashes($task->title) }}')"
                        class="text-sm text-blue-500 hover:underline">
                        Edit
                    </button>

                    <form method="POST" action="/tasks/{{ $task->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm text-red-500 hover:underline">
                            Delete
                        </button>
                    </form>
                </div>

            </div>

            {{-- Edit view (hidden by default) --}}
            <div class="hidden" id="edit-{{ $task->id }}">
                <form method="POST" action="/tasks/{{ $task->id }}/rename" class="flex gap-2">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="title" id="input-{{ $task->id }}"
                        class="border p-1 flex-1 rounded text-sm"
                        value="{{ $task->title }}" required>
                    <button class="bg-blue-500 text-white px-3 rounded text-sm">Save</button>
                    <button type="button"
                        onclick="hideEdit({{ $task->id }})"
                        class="text-sm text-gray-400 hover:underline">Cancel</button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

<script>
    function showEdit(id, title) {
        document.getElementById('view-' + id).classList.add('hidden');
        document.getElementById('edit-' + id).classList.remove('hidden');
        document.getElementById('input-' + id).focus();
    }

    function hideEdit(id) {
        document.getElementById('edit-' + id).classList.add('hidden');
        document.getElementById('view-' + id).classList.remove('hidden');
    }
</script>

</body>
</html>