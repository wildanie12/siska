<?php 
namespace App\Controllers;
use CodeIgniter\Controller;

class Test extends Controller 
{
    public function index()
    {
        $request = $this->request;
        $data = $request->getGet('request');
        return view('welcome_message');
    }
}
?>