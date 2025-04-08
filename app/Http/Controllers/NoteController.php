<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all notes for the authenticated user
        $notes = Note::where('user_id', Auth::id())->with('pages')->get();
        return view('memo.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('memo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'note_title' => 'required|max:50',
            'page_title' => 'required|max:50',
            'page_contents' => 'required|max:1000',
        ]);

        // Create new note
        $note = new Note();
        $note->user_id = Auth::id();
        $note->note_title = $request->note_title;
        $note->save();

        // Create new page
        $page = new Page();
        $page->user_id = Auth::id();
        $page->note_id = $note->id;
        $page->page_title = $request->page_title;
        $page->page_contents = $request->page_contents;
        $page->save();

        return redirect()->route('memo.index')->with('success', 'メモを作成しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Note::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('pages')
            ->firstOrFail();
        
        return view('memo.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        return view('memo.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'page_title' => 'required|max:50',
            'page_contents' => 'required|max:1000',
        ]);

        $page = Page::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $page->page_title = $request->page_title;
        $page->page_contents = $request->page_contents;
        $page->save();

        return redirect()->route('memo.show', $page->note_id)->with('success', 'メモを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $noteId = $page->note_id;
        $page->delete();
        
        // Check if this was the last page in the note
        $remainingPages = Page::where('note_id', $noteId)->count();
        
        if ($remainingPages === 0) {
            // Delete the note if no pages remain
            Note::where('id', $noteId)->where('user_id', Auth::id())->delete();
            return redirect()->route('memo.index')->with('success', 'メモを削除しました');
        }
        
        return redirect()->route('memo.show', $noteId)->with('success', 'ページを削除しました');
    }
    
    /**
     * Add a new page to an existing note
     */
    public function addPage(Request $request, string $noteId)
    {
        $request->validate([
            'page_title' => 'required|max:50',
            'page_contents' => 'required|max:1000',
        ]);
        
        // Check if note exists and belongs to user
        $note = Note::where('id', $noteId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        // Create new page
        $page = new Page();
        $page->user_id = Auth::id();
        $page->note_id = $noteId;
        $page->page_title = $request->page_title;
        $page->page_contents = $request->page_contents;
        $page->save();
        
        return redirect()->route('memo.show', $noteId)->with('success', '新しいページを追加しました');
    }
}
