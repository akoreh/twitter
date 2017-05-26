<?php

namespace App;

use Embed\Embed;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{

    protected $fillable=[

        'user_id',
        'tweet'
    ];

    public function hashtags()
    {
        return $this->belongsToMany('App\Hashtag', 'tweet_hashtags', 'tweet_id', 'hashtag_id');
    }


    public function getEmbed()
    {
        $string = $this->tweet;
        if (preg_match_all('/(https?|ssh|ftp):\/\/[^\s"]+/', $string, $url)) {

            $single_url = $url[0][0];


            if (isset($single_url)) {
                $embed = Embed::create($single_url);

                $embedArray = (array)$embed;

                if(!empty($embedArray)){
                    return $embed;
                }

            } else {
                return false;
            }
        }
    }

    public function getHashtags(){
        $string = $this->tweet;

        if(preg_match_all('/#(\w*[0-9a-zA-Z]+\w*[0-9a-zA-Z])/',$string,$hashtags)){

            return $hashtags;

        }

        return false;

    }

    public function withoutURL(){
        $string =  preg_replace('/https?:\/\/[^\s"<>]+/', '',$this->tweet);

        return $string;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }




}
