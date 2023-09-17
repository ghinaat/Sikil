<?php

namespace App\Http\Controllers;

use App\Models\EmailConfiguration;
use Illuminate\Http\Request;

class EmailConfigurationController extends Controller
{
    public function show()
    {
        return view('email_configuration.show', [
            'email_configuration' => EmailConfiguration::all()[0],
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'protocol' => 'required|string',
            'host' => 'required|string',
            'port' => 'required|string',
            'timeout' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        EmailConfiguration::where('id_email_configuration', 1)->update($validatedData);

        return redirect()->route('emailConfiguration.show')->with('success', 'A Email Configuration Has Been Updated Successful!');

    }
}
