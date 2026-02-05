<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
// NEW METHOD: Display friends and friend requests
        public function index()
        {
            $user = auth()->user();
            
            // Get pending friend requests
            $pendingRequests = $user->receivedFriendRequests()
                ->where('status', 'pending')
                ->with('sender')
                ->latest()
                ->get();
            
            // Get sent friend requests
            $sentRequests = $user->sentFriendRequests()
                ->where('status', 'pending')
                ->with('receiver')
                ->latest()
                ->get();
            
            // Get friends (accepted requests)
            $friends = $user->friends()->get();
            
            return view('friends.index', compact(
                'pendingRequests',
                'sentRequests',
                'friends'
            ));
        }


    public function search(Request $request)
    {
        $search = $request->input('search');

        $friends = [];

        if ($search) {
            $friends = User::where('id', '!=', auth()->id()) 
                ->where('name', 'ILIKE', '%' . $search . '%')
                ->get();
        }

        return view('dashboard', compact('friends', 'search'));
    }

    // NEW METHOD: Send Friend Request
    public function sendRequest(Request $request, $receiverId)
    {
        // Check if receiver exists
        $receiver = User::findOrFail($receiverId);

        // Check if not sending to yourself
        if (auth()->id() == $receiverId) {
            return redirect()->back()->with('error', 'You cannot send a friend request to yourself.');
        }

        // Check if friendship already exists
        $existingFriendship = auth()->user()->friendshipWith($receiver);
        
        if ($existingFriendship) {
            $status = $existingFriendship->status;
            
            if ($status == 'pending') {
                if ($existingFriendship->sender_id == auth()->id()) {
                    return redirect()->back()->with('info', 'Friend request already sent.');
                } else {
                    return redirect()->back()->with('info', 'This user already sent you a friend request.');
                }
            } elseif ($status == 'accepted') {
                return redirect()->back()->with('info', 'You are already friends with this user.');
            } elseif ($status == 'rejected') {
                return redirect()->back()->with('info', 'Friend request was previously rejected.');
            }
        }

        // Create new friend request
        Friendship::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Friend request sent successfully!');
    }

    // NEW METHOD: Accept Friend Request
    public function acceptRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        // Check if the current user is the receiver
        if (auth()->id() != $friendship->receiver_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update status to accepted
        $friendship->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Friend request accepted!');
    }

    // NEW METHOD: Reject Friend Request
    public function rejectRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        // Check if the current user is the receiver
        if (auth()->id() != $friendship->receiver_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update status to rejected
        $friendship->update(['status' => 'rejected']);

        return redirect()->back()->with('info', 'Friend request rejected.');
    }

    // NEW METHOD: Cancel Friend Request
    public function cancelRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);

        // Check if the current user is the sender
        if (auth()->id() != $friendship->sender_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Delete the request
        $friendship->delete();

        return redirect()->back()->with('info', 'Friend request cancelled.');
    }
}