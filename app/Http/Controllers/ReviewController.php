<?php

namespace App\Http\Controllers;

use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReviewController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    //User
    public function delete_review($id)
    {
        review::find($id)->delete();
        return redirect()->back()->with('message', "ลบการรีวิวเสร็จสิ้น");
    }

    public function edit_review($id, Request $request)
    {
        $emoji_pattern = "\x{1F100}-\x{1F1FF}" // Enclosed Alphanumeric Supplement
        ."\x{1F300}-\x{1F5FF}" // Miscellaneous Symbols and Pictographs
        ."\x{1F600}-\x{1F64F}" //Emoticons
        ."\x{1F680}-\x{1F6FF}" // Transport And Map Symbols
        ."\x{1F900}-\x{1F9FF}" // Supplemental Symbols and Pictographs
        ."\x{2600}-\x{26FF}" // Miscellaneous Symbols
        ."\x{2700}-\x{27BF}"; // Dingbats
        $string_without_emojis = preg_replace('/['. $emoji_pattern . ']+/u', '', $request->editReview);

        $response = Http::asForm()->withHeaders([
            'Apikey' => 'QpeThh9VSvLIr0UVyQWP5NXjchaCZMWP',
            'Content-Type' => 'application/json'
        ])->post('https://api.aiforthai.in.th/ssense', [
            'text' => $string_without_emojis
        ]);

        $polarity = $response->json()['sentiment']['polarity'];

        $update_review = review::find($id);
        if ($polarity == 'positive') {
            $update_review->review_type = 1;
        } elseif ($polarity == 'negative') {
            $update_review->review_type = 2;
        } else {
            $update_review->review_type = 3;
        }
        $update_review->review_detail = $request->editReview;
        $update_review->save();
        return redirect()->back()->with('message', "แก้ใขการรีวิวเสร็จสิ้น");
    }
    public function add_review($id, Request $request)
    {
        $emoji_pattern = "\x{1F100}-\x{1F1FF}" // Enclosed Alphanumeric Supplement
        ."\x{1F300}-\x{1F5FF}" // Miscellaneous Symbols and Pictographs
        ."\x{1F600}-\x{1F64F}" //Emoticons
        ."\x{1F680}-\x{1F6FF}" // Transport And Map Symbols
        ."\x{1F900}-\x{1F9FF}" // Supplemental Symbols and Pictographs
        ."\x{2600}-\x{26FF}" // Miscellaneous Symbols
        ."\x{2700}-\x{27BF}"; // Dingbats
        $string_without_emojis = preg_replace('/['. $emoji_pattern . ']+/u', '', $request->review);

        $response = Http::asForm()->withHeaders([
            'Apikey' => 'QpeThh9VSvLIr0UVyQWP5NXjchaCZMWP',
            'Content-Type' => 'application/json'
        ])->post('https://api.aiforthai.in.th/ssense', [
            'text' => $string_without_emojis
        ]);

        $polarity = $response->json()['sentiment']['polarity'];

        $add_review = new review();
        $add_review->booking_id = $id;
        if ($polarity == 'positive') {
            $add_review->review_type = 1;
        } elseif ($polarity == 'negative') {
            $add_review->review_type = 2;
        } else {
            $add_review->review_type = 3;
        }

        $add_review->review_detail = $request->review;
        $add_review->save();

        return redirect()->back()->with('message', "เพิ่มการรีวิวเสร็จสิ้น");
    }

    //Admin
    public function manage_review()
    {

        return view('admin.manage-review');
    }

    public function review_admin()
    {

        return view('admin.review-admin');
    }
    public function review_detail($id)
    {

        return view('admin.review-detail');
    }
}
