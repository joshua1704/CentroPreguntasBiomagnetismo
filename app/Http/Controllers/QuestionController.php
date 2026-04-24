<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class QuestionController extends Controller
{
    public function showEdit($id, $sidebar) {
        $question = DB::table('questions')->where('id', $id)->first();
        $topics = DB::table('topics')->get();

        return view('admin.pages.editQuestion', compact('question', 'topics', 'sidebar'));
    }

    public function store(Request $request) {
        $request->validate(
            [
                'name' => 'required|string',
                'question' => 'required'
            ],
            [
                'name.required' => __('validator.name_required'),
                'name.string' => __('validator.name_string'),
                'question.required' => __('validator.question_required'),
            ]
        );
        try {
            $id = DB::table('questions')->insertGetId([
                        'name' => $request->name,
                        'question' => $request->question,
                        'status' => 1,
                        'topic_id' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

            return redirect()->route('home')->with('success', __('validator.success_question') . $id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('validator.error_question'));
        }
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'question' => 'required',
            'topic_id' => 'required'
        ],
        [
            'id.required' => __('validator.id_required'),
            'name.required' => __('validator.name_required'),
            'question.required' => __('validator.question_required'),
            'topic_id.required' => __('validator.topic_id_required')
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $question = DB::table('questions')->where('id', $request->id)->first();

            if (!$question) {
                return redirect()->back()->with([
                    'error' => __('validator.error_not_find_register'),
                ]);
            }

            $status = $question->status;

            if ($question->status == 'pending' && $request->filled('answer')) {
                $status = 2;
            }

            DB::table('questions')
                ->where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'question' => $request->question,
                    'topic_id' => $request->topic_id,
                    'answer' => $request->answer,
                    'status' => $status
                ]);

            return redirect()->back()->with([
                'success' => 'Actualizado correctamente',
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => __('validator.error_update_question') . ' (' . $th->getMessage() . ')',
            ]);
        }

    }

    public function changeStatusQuestion($id, $status) {
        $question = DB::table('questions')->where('id', $id)->first();

        if ($status == 2 && !$question->answer)
        {
            DB::table('questions')
                ->where('id', $id)
                ->update([
                    'status' => 1
                ]);
        } else {
            DB::table('questions')
                ->where('id', $id)
                ->update([
                    'status' => $status
                ]);
        }

        return redirect()->back();
    }

    public function getQuestions(Request $request, $sidebar) {
        $status = $this->sidebarStatus($sidebar);

        $query = DB::table('questions')
                ->select('questions.id', 'questions.name', 'questions.question', 'questions.answer', 'questions.created_at', 'topics.name as topic', 'topics.id as topic_id')
                ->join('topics', 'topics.id', '=', 'questions.topic_id')
                ->where('status', $status);

        if ($request->filled('topic')) {
            $query->where('questions.topic_id', $request->topic);
        }

        if ($request->filled('date')) {
            switch ($request->date) {
                case 'today':
                    $query->where('questions.created_at', now());
                    break;
                case 'week':
                    $query->where('questions.created_at', '>=', now()->subDays(7));
                    break;
                case 'month':
                    $query->where('questions.created_at', '>=', now()->subDays(30));
                    break;
                case 'last_month':
                    $query->whereBetween('questions.created_at', [
                        now()->subMonth()->startOfMonth(),
                        now()->subMonth()->endOfMonth()
                    ]);
                    break;
                case 'custome_range':
                    if ($request->filled('desdeDate') && $request->filled('hastaDate')) {
                        $from = Carbon::parse($request->desdeDate)->startOfDay();
                        $to = Carbon::parse($request->hastaDate)->endOfDay();

                        $query->whereBetween('questions.created_at', [$from, $to]);
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('questions.name', 'like', '%' . $search. '%')
                    ->orWhere('questions.question', 'like', '%' . $search . '%');
            });
        }

        $questions = $query->paginate(50);
        $topics = DB::table('topics')->get();
        $search_params = $request->only('topic', 'date', 'desdeDate', 'hastaDate', 'search');
        $view = $this->sidebarView($sidebar);

        return view($view, compact('questions', 'topics', 'sidebar', 'search_params'));
    }

    public function publishQuestions(Request $request) {
        $query = DB::table('questions')
        ->join('topics', 'questions.topic_id', '=', 'topics.id')
        ->where('questions.status', 3)
        ->orderBy('questions.id', 'desc')
        ->select('questions.id', 'questions.name', 'questions.question', 'questions.answer', 'questions.created_at', 'questions.topic_id', 'topics.name as topic');

        $search = $request->search;

        if($request->filled('search')) {
            $query->where(function($q) use ($search) {
                $q->where('questions.name', 'like', '%' . $search. '%')
                    ->orWhere('questions.question', 'like', '%' . $search . '%');
            });
        }

        $questions = $query->paginate(50);

        return view('public.respuestas', compact('questions', 'search'));
    }

    public function uploadImage(Request $request) {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    private function sidebarView($sidebar) {
        $view = '';
        switch ($sidebar) {
            case 'pending':
                $view = 'admin.pages.pendingQuestions';
                break;
            case 'answered':
                $view = 'admin.pages.answeredQuestions';
                break;
            case 'published':
                $view = 'admin.pages.publishedQuestions';
                break;
            case 'archived':
                $view = 'admin.pages.archivedQuestions';
                break;
            default:
                $view = 'admin.pages.pendingQuestions';
                break;
        }
        return $view;
    }

    private function sidebarStatus($sidebar) {
        $status = '';
        switch ($sidebar) {
            case 'pending':
                $status = 1;
                break;
            case 'answered':
                $status = 2;
                break;
            case 'published':
                $status = 3;
                break;
            case 'archived':
                $status = 4;
                break;
            default:
                $status = 1;
                break;
        }
        return $status;
    }
}
