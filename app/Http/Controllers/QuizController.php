<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Traits\CreatesViewPaths;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Multitenant;

class QuizController extends Controller
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

    public function show(Request $request) {

    }

    /**
     * Browse all the quizzes stored in the database
     */
    public function browseQuizzes(Request $request) {
        $quizzes = Multitenant::getModel('Quiz')::get();

        if (!$quizzes->count()) {
            $this->fetchQuizzes();
            $this->browseQuizzes($request);
        }

        return response()->json($quizzes);
    }

    protected function fetchQuizzes() {
        /**
         * Fetch quizzes from the API
         * Store each quiz according to API id => quiz_id
         */
        $quizzes = json_decode(\Helper::apiData("https://printful.com/test-quiz.php?action=quizzes"));
        $array = [];
        foreach ($quizzes as $key => $value) {
            // store the quiz one by one.
            if (isset($value->id)) {

                \DB::beginTransaction();

                try {
                    $quiz = Multitenant::getModel('Quiz')::firstOrNew(['quiz_id' => $value->id]);
                    $quiz->title    = $value->title;
                    $quiz->quiz_id  = $value->id;
                    $quiz->save();

                    $array[] = $quiz;

                    \DB::commit();
                } catch (\Exception $e) {
                    \Log::info('errir', [$e]);
                    \DB::rollBack();
                } catch (Exception $e) {
                    \Log::info('errir', [$e]);
                    \DB::rollBack();
                    return response(['result' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
                }
            }
        }
    }

    public function saveQuiz(Request $request) {
        $score = 0;

        $params = "?action=submit&quizId=".$request->id;

        foreach ($request->answers as $key => $value) {
            $params .= "&answers[]=".$value;
        }

        $scoreData = json_decode(\Helper::apiData("https://printful.com/test-quiz.php".$params));

        if (isset($scoreData->correct)) {
            $score = $scoreData->correct;
        }

        $model = Multitenant::getModel('QuizCompleteHistory');
        $model = new $model;
        $model->uuid     = Str::uuid()->toString();
        $model->quiz_id  = $request->id;
        $model->meta     = [
            /**
             * Save the current quiz and results data
             * In case if you will need to fetch the passed quizz results even if the quiz details change.
             */
            'quiz'      => $request->quiz,
            'result'    => $request->result,
            'answers'   => $request->answers,
        ];
        $model->save();

        return response()->json(['id'=> $model->uuid, 'score' => $score]);
    }
}