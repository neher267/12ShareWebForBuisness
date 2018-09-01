<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Questions;
use App\Question;
use Auth;
use Sentinel;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $user = Sentinel::authenticate($request->all());
        if($user)
        {
            $questions = Question::where('category', $user->category)
                    ->where('id', '>', (int) $user->last_id)->get();
            if($questions->count())
            {
                $user->last_id = $questions[$questions->count()-1]->id;
            }
            $user->en_score = (int) request()->en_score;
            $user->math_score = (int) request()->math_score;
            $user->math_error = (int) request()->math_error;
            $user->en_error = (int) request()->en_error;
            $user->save();
            
            return new Questions($questions);
        }
        else
        {
            return abort("401");
        }        
    }

    public function getWormUpTestQuestions()
    {
    	$questions = Question::where('category', '3')->limit(20)->get()->shuffle();
    	return new Questions($questions);
    }

    public function getGameingQuestions()
    {
    	//particular user category
    	//strarting last id
    }
    
}
