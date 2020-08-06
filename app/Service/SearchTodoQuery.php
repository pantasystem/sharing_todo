<?php

namespace App\Service;

use App\User;
use App\Group;

class SearchTodoQuery
{



    public $is_detail = false;

    public $is_start_match = false;

    public $is_end_match = false;

    public $word = null;

    private $group = null;

    private $user = null;


    public function __construct(User $user, $word)
    {
        $this->word = $word;
        $this->user = $user;
    }

    public function setGroup($group): void
    {
        $group_id;
        if(!$group){
            return;
        }
        if($group instanceof Group){
            $group_id = $group->id;
        }else{
            $group_id = $group;
        }

        $this->group = $this->user->groups()->findOrFail($group_id);
    }

    

    public function getGroup(): Group
    {
        return $this->group;

    }

    public function buildQuery()
    {
        $query;
        if($this->group){
            $query = $this->group->todos();
        }else{
            $query = $this->user->todos();
        }

        if(!$this->word){
            return $query;
        }
        $word = '';
        if(!$this->is_start_match){
            $word .= '%';
        }
        $word .= $this->word;
        if(!$this->is_end_match){
            $word .= '%';
        }

        $query = $query->where('title', 'like', $word);

        if($this->is_detail){
            $query = $query->orWhere('description', 'like', $word);
        }

        return $query;
    }


}