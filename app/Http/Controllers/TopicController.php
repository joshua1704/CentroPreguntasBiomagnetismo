<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function index() {
        $sidebar = "topics";
        $topics = DB::table('topics')->get();

        return view('admin.pages.topics', compact('sidebar', 'topics'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:topics,name'
        ], [
            'name.required' => __('validator.name_required'),
            'name.unique' => __('validator.name_unique')
        ]);

        DB::table('topics')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back();
    }
}
