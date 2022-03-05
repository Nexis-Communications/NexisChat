<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{



    public function index()
    {

        if( $this->request->getPOST()) {

            $email = $this->request->getVar('email');
            $nick = $this->request->getVar('nick');
            $pass = $this->request->getVar('pass');

        }

        d($email,$nick,$pass);

        $db = db_connect();
        $query = $db->query('SELECT * from users WHERE `username` = \'' . $nick . '\' LIMIT 1');
        $row = $query->getRow();

        if (isset($row)) {
            dd($row);
        } else {
            dd('User does not exist!');
        }

        dd($this->db);
        //return view('home/index');
    }


}