<?php

if (!function_exists('response_ok')) {
    function response_ok(string $error_title = "", string $error_message = "", array $data = [], array $headers = [])
    {
        return response()->json([
            "response_code" => 200,
            "error_title" => $error_title,
            "error_message" => $error_message,
            "data" => $data
        ], 200)
            ->withHeaders($headers);
    }
}

if (!function_exists('response_created')) {
    function response_created(string $error_title = "", string $error_message = "", array $data = [], array $headers = [])
    {
        return response()->json([
            "response_code" => 201,
            "error_title" => $error_title,
            "error_message" => $error_message,
            "data" => $data
        ], 201)
            ->withHeaders($headers);
    }
}

if (!function_exists('response_invalid_request')) {
    function response_invalid_request(string $error_title = null, string $error_message = null, array $headers = [])
    {
        $error_title = $error_title ?? __("main.messages_title.error");
        $error_message = $error_message ?? __("main.error");

        return response()->json([
            "response_code" => 400,
            "error_title" => $error_title,
            "error_message" => $error_message
        ], 400)
            ->withHeaders($headers);
    }
}

if (!function_exists('response_unauthenticated')) {
    function response_unauthenticated(array $headers = [])
    {
        return response()->json([
            "response_code" => 401,
            "error_title" => __("main.messages_title.login"),
            "error_message" => __("main.please_login"),
            "redirectUrl" => route("login")
        ], 401)
            ->withHeaders($headers);
    }
}

if (!function_exists('response_not_found')) {
    function response_not_found(string $error_title = "", string $error_message = "", array $headers = [])
    {
        return response()->json([
            "response_code" => 404,
            "error_title" => $error_title,
            "error_message" => $error_message
        ], 404)
            ->withHeaders($headers);
    }
}


if (!function_exists('response_server_error')) {
    function response_server_error(string $error_title = null, string $error_message = null, array $headers = [])
    {
        $error_title = $error_title ?? __("main.messages_title.error");
        $error_message = $error_message ?? __('main.error');

        return response()->json([
            "response_code" => 500,
            "error_title" => $error_title,
            "error_message" => $error_message,
        ], 500)
            ->withHeaders($headers);
    }
}
