<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Traits\CreatesViewPaths;
use Illuminate\Http\Request;
use App\Helpers\Multitenant;

class AnswerController extends Controller
{
    use CreatesViewPaths;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->fetchAnswers();
        return view('welcome');
    }

    public function fetchAnswers() {
        /*
         *  Get the fetched questions!
         */
        $questions = Multitenant::getModel('Question')::get();
        foreach ($questions as $k => $v) {
            // Get the questions for the current quiz.
            $answers = json_decode(
                \Helper::apiData("https://printful.com/test-quiz.php?action=answers&quizId=".$v->quiz_id."&questionId=".$v->question_id)
            );
            foreach ($answers as $key => $value) {
                // store the quiz questions one by one.
                if (isset($value->id)) {
                    $question = Multitenant::getModel('Answer')::firstOrNew(['answer_id' => $value->id]);
                    $question->title    = $value->title;
                    $question->quiz_id  = $v->quiz_id;
                    $question->question_id = $v->question_id;
                    $question->save();
                }
            }
        }
    }
}