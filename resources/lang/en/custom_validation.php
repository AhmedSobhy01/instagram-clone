<?php

return [
    "name" => [
        "required" => "Name is required.",
        "string" => "Name is invalid.",
        "max:50" => "Name can't be more than 50 character.",
    ],
    "username" => [
        "required" => "Username is required.",
        "string" => "Username is invalid.",
        "max:20" => "Username can't be more than 20 character.",
        "unique" => "Username has already been taken.",
    ],
    "email" => [
        "required" => "Email Address is required.",
        "email" => "Email must be a valid email address.",
        "max:255" => "Email can't be more than 255 character.",
        "unique" => "Email has already been used before.",
    ],
    "bio" => [
        "required" => "Bio is required.",
        "email" => "Bio is invalid.",
        "max:150" => "Bio can't be more than 150 character.",
    ],
    "website" => [
        "required" => "Website is required.",
        "url" => "Website is invalid.",
        "max:50" => "Bio can't be more than 50 character.",
    ],
    "post_id" => [
        "required" => "Post id must required.",
        "integer" => "Post id must be an integer.",
    ],
    "comment" => [
        "required" => "Comment can't be empty.",
        "string" => "Comment must be a string.",
        "max:255" => "Comment can't be more than 255 character.",
    ],
];