<?php

if (!function_exists('saveCurrentUrl')) {
    /**
     *
     * Saves the current url in the session so it can be used to redirect back to the same page after logging in or out.
     *
     * @param string $redirectTo
     *
     */
    function saveCurrentUrl(string $redirectTo = null)
    {
        $redirectTo = $redirectTo  ?? url()->previous();
        session()->put('redirectTo', $redirectTo);
        return true;
    }
}

if (!function_exists('response_ok')) {
    /**
     * Return a json response with 200 http code.
     *
     * @param  string  $error_title
     * @param  string  $error_message
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     *
     */
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
    /**
     * Return a json response with 201 http code.
     *
     * @param  string  $error_title
     * @param  string  $error_message
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     *
     */
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
    /**
     * Return a json response with 400 http code. Used when the request inputs is incomplete or corrupted.
     *
     * @param  string  $error_title
     * @param  string  $error_message
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     *
     */
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
    /**
     * Return a json response with 401 http code. Used when user is not logged in.
     *
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     *
     */
    function response_unauthenticated(array $headers = [])
    {
        saveCurrentUrl();

        return response()->json([
            "response_code" => 401,
            "error_title" => __("main.messages_title.login"),
            "error_message" => __("main.please_login"),
            "redirectUrl" => route("login")
        ], 401)
            ->withHeaders($headers);
    }
}

if (!function_exists('response_forbidden')) {
    /**
     * Return a json response with 401 http code. Used when user is not logged in.
     *
     * @param  string  $error_title
     * @param  string  $error_message
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     *
     */
    function response_forbidden(string $error_title = null, string $error_message = null, array $headers = [])
    {
        $error_title = $error_title ?? __("main.messages_title.forbidden");
        $error_message = $error_message ?? __("main.forbidden");

        return response()->json([
            "response_code" => 401,
            "error_title" => $error_title,
            "error_message" => $error_message
        ], 401)
            ->withHeaders($headers);
    }
}

if (!function_exists('response_not_found')) {
    /**
     * Return a json response with 404 http code. Used when a resource is not found.
     *
     * @param  string  $error_title
     * @param  string  $error_message
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     *
     */
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
    /**
     * Return a json response with 500 http code.
     *
     * @param  string  $error_title
     * @param  string  $error_message
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     *
     */
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

if (!function_exists('shorten_number')) {
    /**
     * Return a json response with 500 http code.
     *
     * @param  int  $number
     * @return string
     *
     */
    function shorten_number(int $number)
    {
        $suffix = ["", "K", "M", "B"];
        $precision = 2;
        for ($i = 0; $i < count($suffix); $i++) {
            $divide = $number / pow(1000, $i);
            if ($divide < 1000) {
                return round($divide, $precision) . $suffix[$i];
                break;
            }
        }
    }
}