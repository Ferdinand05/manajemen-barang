<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLogin;

class Login extends BaseController
{
    protected $modelLogin;

    public function __construct()
    {
        $this->modelLogin = new ModelLogin();
    }

    public function index()
    {
        return view('login/index');
    }


    public function cekUser()
    {

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $validation = \Config\Services::validation();
        $rules = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak boleh Kosong!',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong!'
                ]
            ]
        ]);

        if (!$rules) {

            $errorMsg = [
                'errUsername' => $validation->getError('username'),
                'errPassword' => $validation->getError('password')
            ];

            session()->setFlashdata($errorMsg);
            return redirect()->back()->withInput();
        } else {
            $cekUserLogin = $this->modelLogin->builder('users')->getWhere(['username' => $username]);
            // $cekUserLogin = $this->modelLogin->find($username);
            if ($cekUserLogin->getNumRows() == 0) {

                $errorMsg = [
                    'errUsername' => 'Username Tidak Terdaftar!'
                ];
                session()->setFlashdata($errorMsg);
                return redirect()->back()->withInput();
            } else {
                $query = $cekUserLogin->getRowArray();
                $passwordUser = $query['userpassword'];
                if (password_verify($password, $passwordUser)) {
                    // Masuk

                    $idlevel = $query['userlevelid'];
                    $simpan_session = [
                        'username' => $username,
                        'userid' => $query['userid'],
                        'idlevel' => $idlevel,
                    ];
                    session()->set($simpan_session);
                    return redirect()->to(base_url('main/index'));
                } else {
                    $errorMsg = [
                        'errPassword' => 'Password  Salah!'
                    ];

                    session()->setFlashdata($errorMsg);
                    return redirect()->back()->withInput();
                }
            }
        }
    }

    public function logout()
    {



        session()->destroy();
        return redirect()->to('/');
    }
}
