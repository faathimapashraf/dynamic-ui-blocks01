<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard | eCommerce Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Simple line icons for clean ecommerce look (minimal, no extra content) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Only structural styles, no dummy content */
        .sidebar-transition {
            transition: all 0.2s ease;
        }
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased flex">

    <!-- SIDEBAR - eCommerce style (clean, product-navigation feel) -->
    <aside class="w-64 bg-gray-900 text-white shadow-xl h-screen sticky top-0 flex flex-col">
        <div class="p-6 border-b border-gray-800">
            <h2 class="text-2xl font-bold tracking-tight">UI Blocks</h2>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="/client" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition font-medium">
                <i class="fas fa-tachometer-alt w-5 text-gray-400"></i>
                <span>Home</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition font-medium">
                <i class="fas fa-user w-5 text-gray-400"></i>
                <span>Profile</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition font-medium">
                <i class="fas fa-cog w-5 text-gray-400"></i>
                <span>Settings</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-800 text-xs text-gray-500">
            <i class="fas fa-store mr-1"></i> eCommerce view
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- HEADER - clean ecommerce style -->
        <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-10 flex justify-between items-center px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600 text-sm font-medium">{{ auth()->user()->name }}</span>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="flex items-center gap-2 bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-black transition text-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- MAIN CONTENT - eCommerce alignment (grid-friendly, product card layout) -->
        <main class="px-6 py-8 flex-1 overflow-y-auto">

            @forelse($blocks as $block)
                @php $content = $block->content ?? []; @endphp

                {{-- BANNER BLOCK - full width hero (ecommerce style) --}}
                @if($block->type === 'banner')
                <div class="mb-8 rounded-xl overflow-hidden shadow-md">
                    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white p-8 md:p-10">
                        <h2 class="text-3xl md:text-4xl font-bold mb-2">{{ $block->title }}</h2>
                        <p class="text-base opacity-95">{{ $content['description'] ?? '' }}</p>
                    </div>
                </div>
                @endif

                {{-- CARD BLOCK - eCommerce product card style (grid-ready, clean) --}}
                @if($block->type === 'card')
                <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                    <div class="p-5">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-gray-500 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $block->title }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ $content['text'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- LIST BLOCK - clean category/list layout (ecommerce style) --}}
                @if($block->type === 'list')
                <div class="mb-8 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-100">{{ $block->title }}</h3>
                    <ul class="space-y-2">
                        @foreach($content['items'] ?? [] as $item)
                            <li class="flex items-center gap-2 text-gray-700 text-sm">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- STATS BLOCK - metrics grid (ecommerce KPI alignment) --}}
                @if($block->type === 'stats')
                <div class="mb-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($content['stats'] ?? [] as $stat)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center card-hover">
                                <div class="text-2xl font-bold text-gray-800">{{ $stat['value'] }}</div>
                                <div class="text-gray-500 text-xs uppercase tracking-wide mt-1">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            @empty
                {{-- Empty state - no dummy data, just clean message --}}
                <div class="text-center text-gray-500 py-20">
                    <i class="fas fa-cubes text-4xl text-gray-300 mb-3 block"></i>
                    <p>No UI blocks configured by admin.</p>
                </div>
            @endforelse

        </main>
    </div>

</body>
</html>