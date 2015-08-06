<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class EntriesController extends Controller
{

    public function create(Request $request)
    {
        //return $request->all();
        //return $request->input('token');

        if ($request->input('token') != env('SLACK_TOKEN')) {

            return 'Sorry, you need to make sure your slack token is set up correctly.';
        }

        $freckle_token = str_replace('FRECKLE_TOKEN_', '', env('SLACK_USER_'.$request->input('user_id')));

        if (!$freckle_token) return 'Sorry, I can\'t find a freckle token for your slack user ('.$request->input('user_id').')';

        $text = $request->input('text');
        
        return 'Use this format: `'.$request->input('command').' [time spent][project name] description of what you did`';
    }

    private function projects(){

        $projects_url = 'https://'.env('FRECKLE_SUBDOMAIN').'.letsfreckle.com/api/projects.json?token='.$freckle_token;
        $projects = file_get_contents($projects_url);
    }
}