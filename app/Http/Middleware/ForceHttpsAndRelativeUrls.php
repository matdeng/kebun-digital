<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsAndRelativeUrls
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->server('HTTP_X_FORWARDED_HOST')) {
            $host = $request->server('HTTP_X_FORWARDED_HOST');
            $scheme = $request->server('HTTP_X_FORWARDED_PROTO', 'https');
            $dynamicBaseUrl = "$scheme://$host";
            $staticBaseUrl = config('app.url');

            if ($response->headers->has('Location')) {
                $location = $response->headers->get('Location');
                $response->headers->set('Location', str_replace($staticBaseUrl, $dynamicBaseUrl, $location));
            }

            if (is_string($response->getContent())) {
                $content = str_replace($staticBaseUrl, $dynamicBaseUrl, $response->getContent());

                // Specifically look for `localhost:8003` to catch missed config entries
                $content = str_replace(['http://localhost:8003', 'https://localhost:8003'], $dynamicBaseUrl, $content);

                // Rewrite asset URLs (like CSS/JS files and images)
                $response->setContent($content);
            }
        }

        return $response;
    }
}
