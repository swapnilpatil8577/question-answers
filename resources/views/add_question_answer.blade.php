<!DOCTYPE html>
<html>

<head>
    <title>Questions and Answers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bootstrap 4 Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="panel-group">
            <div class="panel panel-default">
                <h4>Add New Call</h4>
                <div class="panel-heading">Add New Question: answerChoice</div>
                @php
                    if (!empty(Session::get('success')))
                    {                            
                        @endphp
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! Session::get('success') !!}</li>
                            </ul>
                        </div>
                        @php
                    }
                    @endphp

                    @if ($errors->any() || Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach

                        @php
                        if (Session::has('error'))
                        { 
                            @endphp
                            <li>{{ Session::get('error') }}</li>
                            @php
                        }
                        @endphp
                        </ul>
                    </div>
                    @endif
                    <div class="panel-body">
                        <form class="formmain" action="{{url('/save_question_answer')}}" method="post" name="manage_que_ans" id="manage_que_ans" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf
                            <div id="addQuestionForm"></div>

                            <!--<div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">City</label>
                                    <input type="text" class="form-control" id="questionTitle_0">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">State</label>
                                    <select id="questionType" class="form-control" onchange="selectedType(this)">
                                        <option selected>Choose...</option>
                                        <option value="multi-line">Multi-line text</option>
                                        <option value="single-choice">Single Choice</option>
                                        <option value="multi-choice">Multiple Choice</option>
                                    </select>
                                </div>
                            </div>-->
                            <div class="form-group commformgroup btngroup">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{url('/')}}" class="commbtn" data-dismiss="modal">Cancel</a>
                                <!--<button type="button" class="btn btn-secondary">Cancel</button>-->
                                <button type="button" class="btn btn-primary pull-right" onclick="buildFormSkeloton()"> <i class="fa fa-plus" aria-hidden="true"></i> Add New Question</button>
                            </div>
                            <input type="hidden" name="id" id="id">
                        </form>
                    </div>
                </div>
            <div>
        </div>
        </div>
    </div>
</body>

</html>

<script>

    var questionCount = 0;
    var answerCount = 0;
    // get references to select list and display text box

    // Common templates
    var singleChoiceTemplate = `<input type="text" class="form-control" name="answer[]" id="singleChoiceAns<%=questionCount %>" placeholder="Enter answer">
    <button type="button" class="btn btn-secondary" onclick="addSubQueSingleChoice()"> <i class="fa fa-plus" aria-hidden="true"></i> Add Sub-Question</button>
    <div id="addsubquestion_singlechoice"></div>
    `;

    var multiLIneTemplate = `<textarea type="text" class="form-control" name="answer[]" id="singleChoiceAns<%=questionCount %>"  rows="3" cols="50" placeholder="Enter answer"></textarea>
    <button type="button" class="btn btn-secondary" onclick="addSubQuestionMultitext()"> <i class="fa fa-plus" aria-hidden="true"></i> Add Sub-Question</button>
    <div id="addsubquestion_multitext"></div>`;

    var multiChoice = `
        <input type="text" class="form-control" name="answer[]" id="singleChoiceAns<%=questionCount %>" placeholder="Enter answer"> </br>
        <input type="text" class="form-control" name="answer[]" id="singleChoiceAns<%=questionCount %>" placeholder="Enter answer"> </br>
        <input type="text" class="form-control" name="answer[]" id="singleChoiceAns<%=questionCount %>" placeholder="Enter answer"> </br>
        <input type="text" class="form-control" name="answer[]" id="singleChoiceAns<%=questionCount %>" placeholder="Enter answer"> </br>
        <input type="text" class="form-control" name="answer[]" id="singleChoiceAns<%=questionCount %>" placeholder="Enter answer">
        <button type="button" class="btn btn-secondary" onclick="addSubQuestionMultiChoice()"> <i class="fa fa-plus" aria-hidden="true"></i> Add Sub-Question</button>
        <div id="addsubquestion_multichoice"></div>`;

    function selectedType(el) {
        var parsedTemplate = '';
        var data = { questionCount: questionCount };
        var selected = $(el).find('option:selected');
        var ansCount = selected.data('count');
        var ansTypeId = '#AnswerType' + ansCount;
        if (el.value === 'single-choice') {
            parsedTemplate = _.template(singleChoiceTemplate);
        } else if (el.value === 'multi-line') {
            parsedTemplate = _.template(multiLIneTemplate);
        } else {
            parsedTemplate = _.template(multiChoice);
        }

        $(ansTypeId).html(parsedTemplate(data));
    }

    function addNewQuestion() {
        questionCount++;
    }

    function buildFormSkeloton() {
        var data = { questionCount: questionCount }
        var template = `<div class="form-row">
            <div class="form-group">
                <label for="inputCity">`+ questionCount+ `</label>
            </div>
            <div class="form-group col-md-6">
                <!--<label for="inputCity">Add Question</label>-->
                <input type="text" class="form-control" name="question[]" id="questionTitle<%=questionCount %>" placeholder="Enter question">
            </div>
            <div class="form-group col-md-4">
                <!--<label for="inputState">State</label>-->
                <select id="questionType<%=questionCount %>" class="form-control" onchange="selectedType(this)">
                    <option selected>Choose...</option>
                    <option value="multi-line" data-count="<%=questionCount %>">Multi-line text</option>
                    <option value="single-choice" data-count="<%=questionCount %>">Single Choice</option>
                    <option value="multi-choice" data-count="<%=questionCount %>">Multiple Choice</option>
                </select>
            </div>
            <div id="AnswerType<%=questionCount %>"></div>
        </div>`;
        var parsedTemplate = _.template(template);
        $('#addQuestionForm').append(parsedTemplate(data));
        questionCount++;
    }

    function addSubQueSingleChoice()
    {
        var subquefield = '<input type="text" class="form-control" name="sub_question[]" id="questionTitle<%=questionCount %>" placeholder="Enter sub-question">';
        $('#addsubquestion_singlechoice').html(subquefield);
    }
    function addSubQuestionMultitext()
    {
        var subquefield = '<input type="text" class="form-control" name="sub_question[]" id="questionTitle<%=questionCount %>" placeholder="Enter sub-question">';
        $('#addsubquestion_multitext').html(subquefield);
    }
    function addSubQuestionMultiChoice()
    {
        var subquefield = '<input type="text" class="form-control" name="sub_question[]" id="questionTitle<%=questionCount %>" placeholder="Enter sub-question">';
        $('#addsubquestion_multichoice').html(subquefield);
    }

</script>