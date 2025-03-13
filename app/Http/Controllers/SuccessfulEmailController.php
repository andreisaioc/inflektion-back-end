<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuccessfulEmail;
use App\Services\EmailParserService;


class SuccessfulEmailController extends Controller
{

    protected $emailParserService;

    public function __construct(EmailParserService $emailParserService)
    {
        $this->emailParserService = $emailParserService;
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string'
        ]);

        $email = SuccessfulEmail::create($request->all());
        $plainText = $this->emailParserService->parseEmailContent($email->email);

        $email->update(['raw_text' => $plainText]);

        return response()->json($email, 201);
    }

    public function getById($id)
    {
        $email = SuccessfulEmail::findOrFail($id);
        return response()->json($email);
    }

    public function update(Request $request, $id)
    {
        $email = SuccessfulEmail::findOrFail($id);
        $email->update($request->all());

        return response()->json($email);
    }

    public function getAll()
    {
        $emails = SuccessfulEmail::whereNull('deleted_at')->get();
        return response()->json($emails);
    }

    public function deleteById($id)
    {
        $email = SuccessfulEmail::findOrFail($id);
        $email->delete();

        return response()->json(['message' => 'Record soft deleted successfully']);
    }
}
