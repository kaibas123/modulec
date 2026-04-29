<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
//        set middleware all of functions
        $middleware->append(\App\Http\Middleware\JSONMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
//        if validate error come return special message
        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();

            foreach ($errors as $i => $v) {
                $errors[$i] = ["message" => $v[0]];
            }

            return response()->json([
                "status" => "invalid",
                "message" => "Request body is not vaild",
                "violations" => $errors
            ], 400);
        });

//        if authorization error come return special message
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            $token = request()->bearerToken();

            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            $user = $accessToken?->tokenable()->withTrashed()->first();

            if ($user) {
                return response()->json([
                   "status" => "blocked",
                   "message" => "User blocked",
                   "reason" => "You have been blocked ". ($user->blocked == "spamming" ? "for spamming" : ($user->blocked == "cheating" ? "for cheating" : "by an administrator"))
                ]);
            } else {
                return response()->json([
                    "status" => "unauthenticated",
                    "message" => !$request->bearerToken() ? "Missing token" : "Invalid token"
                ], 401);
            }
        });

//        if 404 error come return special message
        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->json([
                "status" => "not-found",
                "message" => "Not found"
            ]);
        });
    })->create();
