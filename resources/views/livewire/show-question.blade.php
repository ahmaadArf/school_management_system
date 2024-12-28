<div>
    <div>
        <div class="card card-statistics mb-30">
            <div class="card-body">
                <h5 class="card-title"> {{$question[$counter]->title}}</h5>

                @foreach(preg_split('/(-)/', $question[$counter]->answers) as $index=>$answer)
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio{{$index}}" name="customRadio" class="custom-control-input" inh>
                        <label class="custom-control-label" for="customRadio{{$index}}" wire:click="nextQuestion({{$question[$counter]->id}}, {{$question[$counter]->score}}, '{{$answer}}', '{{$question[$counter]->right_answer}}')"> {{$answer}}</label>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>
