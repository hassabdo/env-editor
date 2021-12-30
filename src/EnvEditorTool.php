<?php

namespace Hassen\EnvEditor;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool as BaseTool;

class EnvEditorTool extends BaseTool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('env-editor', __DIR__.'/../dist/js/tool.js');
        Nova::style('env-editor', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('env-editor::navigation');
    }
}
