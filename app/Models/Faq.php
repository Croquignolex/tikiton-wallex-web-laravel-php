<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'fr_question', 'fr_answer', 'en_question', 'en_answer'
    ];

    /**
     * @return mixed
     */
    public function getFormatQuestionAttribute()
    {
        $language = App::getLocale();
        if($language === 'en') return $this->en_question;
        else return $this->fr_question;
    }

    /**
     * @return mixed
     */
    public function getFormatAnswerAttribute()
    {
        $language = App::getLocale();
        if($language === 'en') return $this->en_answer;
        else return $this->fr_answer;
    }

    /**
     * @return mixed
     */
    public function getAuthorisedAttribute()
    {
        return Auth::user()->role->type !== Role::USER;
    }
}
