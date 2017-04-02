<?php

namespace Hourglass\Http\Controllers\Administration;

class PluginController extends AdminController
{
    public function index()
    {
        return view('Hourglass::backend.pages.plugin.list');
    }
}
