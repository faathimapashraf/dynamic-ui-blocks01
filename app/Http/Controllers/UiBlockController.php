<?php

namespace App\Http\Controllers;

use App\Models\UiBlock;
use Illuminate\Http\Request;

class UiBlockController extends Controller
{
 



// Admin: list blocks
    public function index()
    {
        $blocks = UiBlock::orderBy('display_order')->get();
        return view('admin.blocks.index', compact('blocks'));
    }
private function formatContent($type, $content)
{
    if (!$content) return [];

    // ✅ If already JSON → decode it to array
    $decoded = json_decode($content, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        return $decoded; // ⚠️ return ARRAY (not json_encode)
    }

    switch ($type) {

        case 'banner':
            return ['description' => $content];

        case 'card':
            return ['text' => $content];

        case 'list':
            return [
                'items' => array_values(array_filter(explode("\n", $content)))
            ];

        case 'stats':
            $rows = explode(',', $content);
            $result = [];

            foreach ($rows as $row) {
                [$label, $value] = explode(':', $row) + [null, null];

                if ($label && $value) {
                    $result[] = [
                        'label' => trim($label),
                        'value' => trim($value)
                    ];
                }
            }

            return ['stats' => $result];

        default:
            return [];
    }
}

public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required',
        'type' => 'required',
        'status' => 'required',
        'display_order' => 'nullable|integer',
        'content' => 'nullable'
    ]);

    $data['content'] = $this->formatContent($request->type, $request->content);

    UiBlock::create($data);

    return back()->with('success', 'Block added successfully.');
}

    // ✅ Make sure content is not null


    // Admin: update block
public function update(Request $request, $id)
{
    $block = UiBlock::findOrFail($id);

    $data = $request->validate([
        'title' => 'required',
        'type' => 'required',
        'status' => 'required',
        'display_order' => 'nullable|integer',
        'content' => 'nullable'
    ]);

    $data['content'] = $this->formatContent($request->type, $request->content ?? '');

    $block->update($data);

    return back()->with('success', 'Block updated successfully.');
}

    // Admin: delete block
    public function destroy($id)
    {
        UiBlock::destroy($id);
        return back()->with('success', 'Block deleted successfully.');
    }

    // Client dashboard
    public function clientDashboard()
    {
        $blocks = UiBlock::where('status', 'Active')->orderBy('display_order')->get();
        return view('client.dashboard', compact('blocks'));
    }
}