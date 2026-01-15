<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{

    public function index()
    {
        $games = Game::paginate(12);
        return view('games.index', compact('games'));
    }

 
    public function create()
    {
        return view('games.create');
    }

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

    public function show(Game $game)
    {
        $reviews = $game->reviews()->with('user')->latest()->paginate(10);
        $averageRating = $game->averageRating();
        $reviewCount = $game->reviewCount();
        
        return view('games.show', compact('game', 'reviews', 'averageRating', 'reviewCount'));
    }

    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

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
       
            if ($game->image && Storage::disk('public')->exists($game->image)) {
                Storage::disk('public')->delete($game->image);
            }
            $data['image'] = $request->file('image')->store('games', 'public');
        }

        $game->update($data);

        return redirect()->route('games.index')->with('success', 'Game updated successfully!');
    }

    public function destroy(Game $game)
    {
        if ($game->image && Storage::disk('public')->exists($game->image)) {
            Storage::disk('public')->delete($game->image);
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Game deleted successfully!');
    }

 
    public function byGenre($genre)
    {
       
        $properGenre = ucfirst(strtolower($genre));
        $games = Game::where('genre', $properGenre)->paginate(12);
        
    
        return view('games.index', compact('games', 'genre'));
    }

 
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
