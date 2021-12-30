<?php

namespace Hassen\EnvEditor\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Hassen\EnvEditor\EnvEditorTool;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        return app(EnvEditorTool::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}
