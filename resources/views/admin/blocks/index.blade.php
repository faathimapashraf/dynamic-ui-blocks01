<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UI Blocks Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-8 px-4">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">UI Blocks</h1>
            <p class="text-gray-500">Manage frontend layout</p>
        </div>

        <div class="flex gap-3">
            <button onclick="toggleForm()"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                + Add Block
            </button>

            <button onclick="window.location.href='/'"
                class="bg-gray-800 text-white px-4 py-2 rounded-lg">
                Logout
            </button>
        </div>
    </div>

    <!-- ADD FORM -->
    <div id="formSection" class="hidden bg-white p-6 rounded-xl shadow mb-6">

        <form method="POST" action="/admin/blocks" class="grid md:grid-cols-2 gap-4">
            @csrf

            <input type="text" name="title" placeholder="Title" required
                class="border p-2 rounded">

            <select name="type" id="typeSelect" class="border p-2 rounded">
                <option value="banner">Banner</option>
                <option value="card">Card</option>
                <option value="list">List</option>
                <option value="stats">Stats</option>
            </select>

            <select name="status" class="border p-2 rounded">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <input type="number" name="display_order"
                placeholder="Order"
                class="border p-2 rounded">

            <div class="md:col-span-2">
                <textarea name="content" id="contentBox"
                    class="border p-2 rounded w-full"
                    placeholder="Enter content"></textarea>

                <!-- RED HELP TEXT -->
                <p id="helpText"
                   class="text-red-600 text-sm font-semibold mt-2"></p>
            </div>

            <button class="bg-green-600 text-white py-2 rounded">
                Save
            </button>
        </form>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded shadow overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">Title</th>
                    <th class="p-2">Type</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Order</th>
                    <th class="p-2">Content</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>

            <tbody>

            @foreach($blocks as $block)
            <tr class="border-t">

                <!-- UPDATE FORM -->
                <form method="POST" action="/admin/blocks/{{ $block->id }}">
                    @csrf

                    <!-- TITLE -->
                    <td class="p-2">
                        <input type="text" name="title"
                            value="{{ $block->title }}"
                            class="border p-1 rounded w-full">
                    </td>

                    <!-- TYPE -->
                    <td class="p-2">
                        <select name="type" class="border p-1 rounded">
                            <option value="banner" {{ $block->type=='banner'?'selected':'' }}>Banner</option>
                            <option value="card" {{ $block->type=='card'?'selected':'' }}>Card</option>
                            <option value="list" {{ $block->type=='list'?'selected':'' }}>List</option>
                            <option value="stats" {{ $block->type=='stats'?'selected':'' }}>Stats</option>
                        </select>
                    </td>

                    <!-- STATUS -->
                    <td class="p-2">
                        <select name="status" class="border p-1 rounded">
                            <option value="Active" {{ $block->status=='Active'?'selected':'' }}>Active</option>
                            <option value="Inactive" {{ $block->status=='Inactive'?'selected':'' }}>Inactive</option>
                        </select>
                    </td>

                    <!-- ORDER -->
                    <td class="p-2">
                        <input type="number" name="display_order"
                            value="{{ $block->display_order }}"
                            class="border p-1 rounded w-20">
                    </td>

                    <!-- CONTENT -->
                    <td class="p-2">
<textarea name="content" class="border p-1 rounded w-full text-xs">
@if($block->type == 'list')
{{ implode("\n", $block->content['items'] ?? []) }}

@elseif($block->type == 'stats')
{{ collect($block->content['stats'] ?? [])
    ->map(fn($s) => $s['label'].':'.$s['value'])
    ->implode(', ') }}

@elseif($block->type == 'banner')
{{ $block->content['description'] ?? '' }}

@elseif($block->type == 'card')
{{ $block->content['text'] ?? '' }}
@endif
</textarea>
                    </td>

                    <!-- ACTIONS -->
                    <td class="p-2 flex gap-2">

                        <!-- UPDATE -->
                        <button type="submit"
                            class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                            Update
                        </button>

                </form>

                        <!-- DELETE -->
                        <form method="POST" action="/admin/blocks/{{ $block->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                Delete
                            </button>
                        </form>

                    </td>

            </tr>
            @endforeach

            </tbody>

        </table>

    </div>

</div>

<!-- JS -->
<script>
function toggleForm() {
    document.getElementById('formSection').classList.toggle('hidden');
}

const typeSelect = document.getElementById('typeSelect');
const helpText = document.getElementById('helpText');

function updateHelp() {
    let type = typeSelect.value;

    if (type === 'banner') {
        helpText.innerText = "🔴 Banner → Enter simple text (Example: Welcome)";
    }
    else if (type === 'card') {
        helpText.innerText = "🔴 Card → Enter description text";
    }
    else if (type === 'list') {
        helpText.innerText = "🔴 List → Each line is a new item";
    }
    else if (type === 'stats') {
        helpText.innerText = "🔴 Stats → Users:120, Orders:50";
    }
}

typeSelect.addEventListener('change', updateHelp);
updateHelp();
</script>

</body>
</html>