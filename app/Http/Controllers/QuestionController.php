<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Traits\CreatesViewPaths;
use Illuminate\Http\Request;
use App\Helpers\Multitenant;

class QuestionController extends Controller
{
    use CreatesViewPaths;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function test(Request $request)
    {
        $response = [
            'test' => 'blah!',
            'blah' => 'test'
        ];
        return response()->json($response);
    }

    public function browseQuestions(Request $request, $quiz_id) {
        $questions = Multitenant::getModel('Question')::where('quiz_id', $quiz_id)->with('answers')->get();

        if (!$questions->count()) {
            ini_set('max_execution_time', 300);
            $this->fetchQuestions();
        }

        return response()->json($questions);
    }

    public function fetchQuestions() {
        /*
         *  Get the fetched questions!
         *  As the quizzes are only three I dont assign any limit to the query
         */
        $quizzes = Multitenant::getModel('Quiz')::get();
        foreach ($quizzes as $k => $v) {
            // Get the questions for the current quiz.
            $questions = json_decode(\Helper::apiData("https://printful.com/test-quiz.php?action=questions&quizId=".$v->quiz_id));
            foreach ($questions as $key => $value) {
                // store the quiz questions one by one.
                if (isset($value->id)) {
                    $question = Multitenant::getModel('Question')::firstOrNew(['question_id' => $value->id]);
                    $question->title    = $value->title;
                    $question->quiz_id  = $v->quiz_id;
                    $question->save();
                }
            }
        }
    }
}