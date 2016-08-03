<?php namespace Hourglass\Forum\Http\Controllers\Forum;

use Hourglass\Http\Controllers\Controller;

class ListForumsController extends Controller
{

    public function listAction($page = '')
    {
        return view('Hourglass.Forum::main');
    }

}