<?php namespace Communalizer\Forum\Controllers\Forum;

use Communalizer\Backend\Http\Controllers\Controller;

class ListForumsController extends Controller
{

    public function listAction($page = '')
    {
        return view('Communalizer.Forum::main');
    }

}