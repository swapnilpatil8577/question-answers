<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Lang;
use Illuminate\Support\Facades\DB;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;

use Illuminate\Support\Facades\Hash;

use Session;
use Validator;
use App\Http\Controllers\Controller;


class AddQuestionsAnswersController extends BaseController
{
	public function add_question_answer()
	{
		return view('add_question_answer');
    }

    public function saveQuestionAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required'
        ]);
        
        $question = $request->input('question');
        $answer = $request->input('answer');

        if(!$question && !$answer)
        {
            $message = "To add questions and answers are mandatory.";
            return redirect('add_question_answer')->with('error',$message);
        }

        if(!$question)
        {
            $message = "Question field is required";
            return redirect('add_question_answer')->with('error',$message);
        }

        if(!$answer)
        {
            $message = "Answer field is required";
            return redirect('add_question_answer')->with('error',$message);
        }

        $sub_question = $request->input('sub_question');

        foreach($question as $k=>$v)
        {
            $questionAnswer[$k]['question'] = $question[$k];
            $questionAnswer[$k]['answer'] = $answer[$k];
            $questionAnswer[$k]['sub_question'] = $sub_question[$k];
        }

        if (!empty($questionAnswer))
        {
            foreach($questionAnswer as $qa)
            {
                $data = array
                (
                    'question' => $qa['question'],
                    'answer' => $qa['answer'],
                    'sub_question' => $qa['sub_question'],
                    'created_date' => date('Y-m-d H:i:s')
                );
    
                $quest_ans_id = DB::table('question_answer')->insertGetId($data);
                $result[] = $quest_ans_id;
            }
    
            if(!empty($result))
            {
                $message = 'Questions and answers added successfully.';
                return redirect('add_question_answer')->with('success',$message);
            }
            else
            {
                $message = 'Failed to save data.';
                return redirect('add_question_answer')->with('error',$message);
            }
        }

        return redirect('add_question_answer')->with('error',$message);
    }
}
?>