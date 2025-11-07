<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerseCollection;
use App\Models\CollectionComment;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * Follow a user.
     */
    public function follow(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        auth()->user()->following()->attach($user->id);

        return back()->with('success', "You are now following {$user->name}.");
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user->id);

        return back()->with('success', "You have unfollowed {$user->name}.");
    }

    /**
     * Like a collection.
     */
    public function likeCollection(VerseCollection $collection)
    {
        if (!auth()->user()->hasLikedCollection($collection)) {
            auth()->user()->likedCollections()->attach($collection->id);
        }

        return response()->json([
            'success' => true,
            'likes_count' => $collection->likes()->count()
        ]);
    }

    /**
     * Unlike a collection.
     */
    public function unlikeCollection(VerseCollection $collection)
    {
        auth()->user()->likedCollections()->detach($collection->id);

        return response()->json([
            'success' => true,
            'likes_count' => $collection->likes()->count()
        ]);
    }

    /**
     * Add a comment to a collection.
     */
    public function commentCollection(Request $request, VerseCollection $collection)
    {
        $request->validate([
            'comment' => 'required|string|max:500'
        ]);

        $comment = CollectionComment::create([
            'user_id' => auth()->id(),
            'collection_id' => $collection->id,
            'comment' => $request->comment
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'html' => view('components.comment-item', ['comment' => $comment])->render()
        ]);
    }

    /**
     * Delete a comment.
     */
    public function deleteComment(CollectionComment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Show user profile.
     */
    public function profile(User $user)
    {
        $collections = $user->verseCollections()
            ->public()
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(12);

        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        $isFollowing = auth()->check() && auth()->user()->isFollowing($user);

        return view('social.profile', compact('user', 'collections', 'followersCount', 'followingCount', 'isFollowing'));
    }

    /**
     * Show discover page (find users to follow).
     */
    public function discover()
    {
        $users = User::where('id', '!=', auth()->id())
            ->withCount(['verseCollections', 'followers'])
            ->orderBy('followers_count', 'desc')
            ->paginate(20);

        return view('social.discover', compact('users'));
    }

    /**
     * Show followers list.
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->withCount('verseCollections')->paginate(20);

        return view('social.followers', compact('user', 'followers'));
    }

    /**
     * Show following list.
     */
    public function following(User $user)
    {
        $following = $user->following()->withCount('verseCollections')->paginate(20);

        return view('social.following', compact('user', 'following'));
    }
}

