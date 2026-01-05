<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the games.
     */
    public function index()
    {
        $games = Game::paginate(12);
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new game.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created game in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('games', 'public');
        }

        Game::create($data);

        return redirect()->route('games.index')->with('success', 'Game created successfully!');
    }

    /**
     * Display the specified game.
     */
    public function show(Game $game)
    {
        $reviews = $game->reviews()->with('user')->latest()->paginate(10);
        $averageRating = $game->averageRating();
        $reviewCount = $game->reviewCount();
        
        return view('games.show', compact('game', 'reviews', 'averageRating', 'reviewCount'));
    }

    /**
     * Show the form for editing the specified game.
     */
    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified game in storage.
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($game->image && Storage::disk('public')->exists($game->image)) {
                Storage::disk('public')->delete($game->image);
            }
            $data['image'] = $request->file('image')->store('games', 'public');
        }

        $game->update($data);

        return redirect()->route('games.index')->with('success', 'Game updated successfully!');
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy(Game $game)
    {
        // Delete image if exists
        if ($game->image && Storage::disk('public')->exists($game->image)) {
            Storage::disk('public')->delete($game->image);
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Game deleted successfully!');
    }

    /**
     * Display games by genre
     */
    public function byGenre($genre)
    {
        // Convert URL parameter to proper case to match database values
        $properGenre = ucfirst(strtolower($genre));
        $games = Game::where('genre', $properGenre)->paginate(12);
        
        // Pass the original genre parameter for URL matching
        return view('games.index', compact('games', 'genre'));
    }

    /**
     * Search games
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $games = Game::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('genre', 'LIKE', "%{$query}%")
                    ->paginate(12);
                    
        return view('games.index', compact('games', 'query'));
    }
}
