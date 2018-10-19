<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed fr_answer
 * @property mixed en_answer
 * @property mixed fr_question
 * @property mixed en_question
*/
class Faq extends Model
{
    use LocaleDateTimeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fr_question', 'fr_answer', 'en_question', 'v'
    ];

    /**
     * @return mixed
     */
    public function getFormatQuestionAttribute()
    {
        $question = '';

        if(App::getLocale() === 'fr') $question = $this->fr_question;
        else if (App::getLocale() === 'en') $question = $this->en_question;

        return $question;
    }

    /**
     * @return mixed
     */
    public function getFormatAnswerAttribute()
    {
        $answer = '';

        if(App::getLocale() === 'fr') $answer = $this->fr_answer;
        else if (App::getLocale() === 'en') $answer = $this->en_answer;

        return $answer;
    }
}
