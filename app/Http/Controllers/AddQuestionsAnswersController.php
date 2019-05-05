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
use App\Http\Controllers\Controller;


class AddQuestionsAnswersController extends BaseController
{
	public function add_question_answer()
	{
		return view('add_question_answer');
    }

    public function saveQuestionAnswer(Request $request)
    {
        $question = $request->input('question');
        $answer = $request->input('answer');
        $sub_question = $request->input('sub_question');

		foreach($question as $k=>$v)
		{
			$questionAnswer[$k]['question'] = $question[$k];
            $questionAnswer[$k]['answer'] = $answer[$k];
            $questionAnswer[$k]['sub_question'] = $sub_question[$k];
        }

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
            return redirect('add_questions_answers')->with('success',$message);
        }
        else
        {
            $message = 'Failed to add data';
            return redirect('add_questions_answers')->with('error',$message);
        }
    }
}
?>