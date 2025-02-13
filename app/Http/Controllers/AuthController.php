<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Mail\MailSender;
use Exception;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $smtpConfig = [
            'transport' => 'smtp',
            'host' => 'smtp-relay.brevo.com',
            'port' => 587,
            'from' => ['address' => 'noreply@tbhv3.my.id', 'name' => 'The Brain & Heart Official'],
            'encryption' => 'tls',
            'username' => 'dbi.malang.o@gmail.com',
            'password' => '7YPLNq6KfpydDGBT',
        ];
        config(['mail.mailers.smtp' => $smtpConfig]);
    }

    public function login()
    {
        $data['title'] = "Login ICETy";

        if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 1) {
            return redirect('dashboard');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 2) {
            return redirect('/');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 3) {
            return redirect('/');
        }

        return
            view('template.header', $data) .
            view('auth.login') .
            view('template.footer', $data);
    }

    public function login_authentication(Request $req)
    {
        $auth = DB::selectOne("
            SELECT
                user.*
            FROM
                user
            WHERE
                user.EMAIL = '" . $req->input('email') . "'
            AND
                user.PASS = '" . hash('sha256', md5($req->input('password'))) . "'
        ");


        if ($auth == null) {
            return redirect()->back()->with('msg_auth', "Email or Password Wrong");
        }
        if ($auth->STATUS == 0) {
            return redirect()->back()->with('resp_msg', "Can't login, your account not verified, please check your email");
        }
        if ($auth->IS_DELETE == 1) {
            return redirect()->back()->with('error_msg', "Can't login, your account is getting ban. Contact admin for more info");
        }

        if (!empty($auth)) {
            if ($auth->ID_ROLE == 1) {
                $user_data = collect([
                    'ID_USER' => $auth->ID_USER,
                    'NAME' => $auth->NAME,
                    'ID_ROLE' => $auth->ID_ROLE,
                    'FOTO_PROFILE' => $auth->FOTO_PROFILE,
                    'EMAIL' => $auth->EMAIL,
                    'LOGGED_IN' => TRUE
                ]);

                Session::push('user', $user_data);

                return redirect('dashboard');
            } elseif ($auth->ID_ROLE == 2) {

                $user_data = collect([
                    'ID_USER' => $auth->ID_USER,
                    'NAME' => $auth->NAME,
                    'ID_ROLE' => $auth->ID_ROLE,
                    'FOTO_PROFILE' => $auth->FOTO_PROFILE,
                    'EMAIL' => $auth->EMAIL,
                    'LOGGED_IN' => TRUE
                ]);

                Session::push('user', $user_data);
                return redirect('/');
            } elseif ($auth->ID_ROLE == 3) {

                $user_data = collect([
                    'ID_USER' => $auth->ID_USER,
                    'NAME' => $auth->NAME,
                    'ID_ROLE' => $auth->ID_ROLE,
                    'FOTO_PROFILE' => $auth->FOTO_PROFILE,
                    'EMAIL' => $auth->EMAIL,
                    'LOGGED_IN' => TRUE
                ]);

                Session::push('user', $user_data);
                return redirect('/');
            }
        } else {
            return redirect('login')->with('resp_msg', "Your Session Expired");
        }
    }

    public function register()
    {
        $data['title'] = "Register ICETy";

        return
            view('template.header', $data) .
            view('auth.register') .
            view('template.footer', $data);
    }

    public function store(Request $req)
    {
        $check_user = DB::table('user')
            ->where('EMAIL', $req->input('email'))
            ->get();

        if ($check_user->isEmpty()) {
            $KODE_USER = $this->GenerateUniqID($req->input('name'));

            // Generate a unique user ID
            $KODE_USER = $this->GenerateUniqID($req->input('name'));

            // Create a new user instance
            $User = new User();
            $User->ID_USER = $KODE_USER;
            $User->ID_CATEGORY_USER = $req->input('category_user');
            $User->NAME = $req->input('name');
            $User->EMAIL = $req->input('email');
            $User->PASS = hash('sha256', md5($req->input('password')));
            $User->ID_ROLE = 3;
            $User->STATUS = 0;
            $User->IS_DELETE = 0;
            $User->TELP = $req->input('telp');

            // Save the user to the database
            $User->save();
            DB::table('user_data')->insert(['ID_USER' => $KODE_USER,
                                            'UNIV' =>$req->input('agency')]);
            // Send email verification
            $token_key = bin2hex(random_bytes(32));
            $details = [
                'name' => $req->input('name'),
                'body' => 'Click this link below to verify your email.',
                'link' => url('verification/confirm?token=' . $token_key),
                'button' => "Verify",
            ];
            try {
                $mail = new MailSender($details);
                $mail->subject("Email Verification");
                Mail::to($req->input('email'))->send($mail);
                $formDataToken = [
                    'ID_USER' => $KODE_USER,
                    'KEY' => $token_key,
                    'TYPE' => 2,
                    'STATUS' => 0,
                    'LOG_TIME' => date('Y-m-d H:i:s'),
                ];
                DB::table('token')->insert($formDataToken);

                return redirect('login')->with('succ_msg', 'Your account is registered, Please verify your account in your email before login!');
            } catch(Exception $e){
                return redirect('register')->with('error_msg', 'Failed to send email. Please try again later!');
            }
            // END SEND EMAIL VERIFICATION

            // SAVE TOKEN

        } else {
            return redirect('register')->with('error_msg', 'Email already Registered!');
        }
    }
    public function verifAccount(Request $req)
    {
        $getToken = DB::selectOne('
            SELECT
                *
            FROM
                token
            WHERE
                `KEY` = "' . $req->input('token') . '"
        ');
        if (empty($getToken)) {
            return redirect('login')->with('error_msg', 'Your Account is not Found please register first');
        }

        // $is_active = Login::where('id_login', '=', $getToken->id_login)->get();
        $status = DB::selectOne('
            SELECT
                STATUS,
                ID_USER
            FROM
                user
            WHERE
                ID_USER = "' . $getToken->ID_USER . '"
        ');

        if ($status->STATUS != 1) {
            // ACTIVATE USER
            DB::table('user')->where('ID_USER', '=', $getToken->ID_USER)->update(['STATUS' => 1]);
        }

        return redirect('login')->with('succ_msg', 'Your Account is Activated, You can login now');
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    public function forgot_password(Request $req)
    {
        $data['title'] = 'Forgot Password';

        return view('template.header', $data) .
            view('auth.forgot_password', $data) .
            view('template.footer', $data);
    }
    public function forgot_password_send(Request $req)
    {
        $data['title'] = 'Forgot Password Check Email';
        if (!empty(session('user')[0]['EMAIL'])) {
            $data['email'] = session('user')[0]['EMAIL'];
        } else {
            $data['email'] = $req->input('email');
        }

        $user_data = DB::selectOne('
            SELECT
                ID_USER
            FROM
                user
            WHERE
                EMAIL = "' . $data['email'] . '"
        ');

        if (empty($user_data)) {
            return redirect('forgot-password')->with('resp_msg', 'Email not found in our system. Please Register first!');
        }

        $checking_token = DB::selectOne('
            SELECT
                `KEY`
            FROM
                token
            WHERE
                ID_USER = "' . $user_data->ID_USER . '"
                AND TYPE = 2
        ');

        if (empty($checking_token)) {
            $token_key = bin2hex(random_bytes(32));
            $formDataToken = [
                'ID_USER' => $user_data->ID_USER,
                'KEY' => $token_key,
                'TYPE' => 2,
                'STATUS' => 0,
                'LOG_TIME' => date('Y-m-d H:i:s'),
            ];
            DB::table('token')->insert($formDataToken);
        } else {
            $token_key = bin2hex(random_bytes(32));
            $formDataToken = [
                'KEY' => $token_key,
                'LOG_TIME' => date('Y-m-d H:i:s'),
            ];
            DB::table('token')->where('ID_USER', $user_data->ID_USER)->update($formDataToken);
        }

        $details = [
            'title' => 'Oh snap you forgot your password',
            'body' => "Don't worry click this link below to reset password.",
            'link' => url('reset-password?token=' . $token_key),
            'button' => 'Reset Password'
        ];

        $mail = new MailSender($details);
        $mail->subject("Reset Password");
        if (!empty(session('user')[0]['EMAIL'])) {
            Mail::to(session('user')[0]['EMAIL'])->send($mail);
        } else {
            Mail::to($req->input('email'))->send($mail);
        }


        return view('template.header', $data) .
            view('auth.forgot_password_confirm', $data) .
            view('template.footer', $data);
    }
    public function forgot_password_reset(Request $req)
    {
        $data['title'] = 'Reset Password';
        $data['token'] = DB::table('token')
            ->where('token.KEY', '=', $req->input('token'))
            ->first();

        if (!empty($data['token'])) {
            $dbtimestamp = strtotime($data['token']->LOG_TIME);
            if (time() - $dbtimestamp > 1 * 300) {
                return redirect('forgot-password')->with('resp_msg', "Your token has been expired.");
            }
        } else {
            return redirect('forgot-password')->with('resp_msg', "Token not found in our system.");
        }
        return view('template.header', $data) .
            view('auth.reset_password', $data) .
            view('template.footer', $data);
    }
    public function resetPassword(Request $req)
    {
        $formDataReset = [
            'PASS' => hash('sha256', md5($req->input('password')))
        ];

        DB::table('user')->where('ID_USER', '=', $req->input('id_user'))->update($formDataReset);

        return redirect('login')->with('resp_sts', 'success')->with('succ_msg', 'Your account password has been successfully reset.');
    }

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap = str_replace($vocal, "", $string);
        $begin = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "USR_" . $uniqid . substr(md5(time()), 0, 3);
    }
}
