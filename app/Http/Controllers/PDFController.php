<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
Use PDF;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $users = User::find($id);

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'houseNo' => $users->houseNo,
            'city' => $users->city,
            'province' => $users->province
        ];

        // dd(compact('user'));
          
        $pdf = PDF::loadView('documents.indigency', ['data'=>$data]);
    
        return $pdf->download('document.pdf');
    }
}
