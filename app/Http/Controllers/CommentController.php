<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display grouped comments.
     */
    public function index()
    {
        $groupedComments = [
            'Candy' => [],
            'Call Instructions' => [],
            'Referrals' => [],
            'Signature Requirements' => [],
            'Miscellaneous' => [],
        ];

        $comments = Comment::all();

        foreach ($comments as $comment) {
            $text = strtolower($comment->comments);

            // Skip empty comments
            if (trim($text) === '') {
                continue;
            }

            if (preg_match('/expected ship date: \d{2}\/\d{2}\/\d{2}/i', $text)) {
                $text = preg_replace('/expected ship date: \d{2}\/\d{2}\/\d{2}/i', '', $text);
                $text = trim($text);
            }

            if (strpos($text, 'candy') !== false) {
                $groupedComments['Candy'][] = $text;
            } elseif (strpos($text, 'call me') !== false || strpos($text, "don't call me") !== false) {
                $groupedComments['Call Instructions'][] = $text;
            } elseif (strpos($text, 'referred by') !== false) {
                $groupedComments['Referrals'][] = $text;
            } elseif (strpos($text, 'signature required') !== false) {
                $groupedComments['Signature Requirements'][] = $text;
            } else {
                $groupedComments['Miscellaneous'][] = $text;
            }
        }

        return view('comments.index', compact('groupedComments'));
    }

    /**
     * Update shipdate_expected field based on comment text.
     */
    public function updateShipDates()
    {
        $comments = Comment::pendingShipDate()->get();

        foreach ($comments as $comment) {
            if (preg_match('/expected ship date: (\d{2})\/(\d{2})\/(\d{2})/i', $comment->comments, $matches)) {
                $month = $matches[1];
                $day = $matches[2];
                $year = '20' . $matches[3]; // Convert YY to YYYY
                $formattedDate = "$year-$month-$day 00:00:00";

                $comment->update(['shipdate_expected' => $formattedDate]);
            }
        }

        return redirect()->route('comments.index')->with('success', 'Ship dates updated successfully.');
    }
}
