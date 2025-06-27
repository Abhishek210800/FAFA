<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class MailController extends Controller
{
    public function sendEmail()
    {
        // Dummy test data
        $name = "Abhishek Mishra";
        $email = "abhishek.edu0721@gmail.com";
        $password = "TestPass123"; // Normally you'd generate this with Str::random(10)
        $role = "complainant";     // Or 'respondent' depending on context

        // Send the email
        Mail::to($email)->send(new WelcomeEmail($name, $email, $password, $role));

        return "Email sent successfully";
    }
}
