<?php
namespace Controller;
// require_once __DIR__ . '/../Model/UserModel.php';
// require_once __DIR__ . '/../bin/support/Request.php';
// require_once __DIR__ . '/../bin/support/View.php';
// require_once __DIR__ . '/../bin/support/Validator.php';
// require_once __DIR__ . '/../bin/support/Validator.php';
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;
use Model\UserModel;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validator = new Validator();
    }

    public function index()
    {
        $user = $this->userModel->user();
        // include __DIR__.'/../View/user.php'; <-- bisa menggunakan basic ini
        View::render('user', ['user'=>$user],'layout'); //<-- View::render untuk mengembalikan ke halaman yang dituju misalnya user, dan membawa parameter $user untuk menampilkan data, layout untuk menampilkan navbar jika dibutuhkan
    }

    public function adduser()
    {
        $csrftoken = CSRFToken::generateToken();
        View::render('home',['csrftoken'=>$csrftoken],'layout');
    }

    public function login(Request $request)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];
            error_log("Login request data: " . print_r($data, true));
            $rule = [
                'email' => 'required',
                'password' => 'required'
            ];
            $error = $this->validator->validate($data,$rule);
            if($error){
                View::render('login', ['errors' => $error]);
            } else {
                $result = $this->userModel->onLogin($data['email'], $data['password']);
                if($result){
                    $user = $this->userModel->getUserIdByEmail($data['email']);
                    if($user){
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['email'] = $user['email'];
                    }
                    // View::render('user', ['user'=>$users],'layout');
                    $r = $_ENV['ROUTE_PREFIX'];
                    View::redirectTo($r.'/user');
                } else {
                    $error_m = "gagal login";
                    View::render('login',['error_m'=>$error_m]);
                }
            }
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $r = $_ENV['ROUTE_PREFIX'];
        View::redirectTo($r.'/login');
    }

    public function store(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRFToken::validateToken($request->csrf_token)) {
                View::render('errors/505',[]);
            }
            $data = [
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password
            ];
            $rules = [
                'username' => 'required|min:3|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ];

            $errors = $this->validator->validate($data,$rules);

            if(!empty($errors)){
                $user = $this->userModel->user();
                View::render('user', ['errors' => $errors, 'data' => $data, 'user' => $user]);
                return;
            } else {
                $result = $this->userModel->addUser($data['username'], $data['email'], $data['password']);
                // $result = $this->userModel->addUser($username, $email, $password); <-- jika tidak menggunakan validasi gunakan seperti ini
                if ($result) {
                    $user = $this->userModel->user();
                    View::redirectTo($_ENV['ROUTE_PREFIX'].'/user');
                } else {    
                    echo "Gagal menambahkan user";
                }
            }
        }
    }

    public function getUserId($id)
    {
        $user = $this->userModel->getUserById($id);
        View::render('edit',['user'=>$user]);
    }

    public function update(Request $request,$id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id =$request->id;
            $username =$request->username;
            $email =$request->email;
            $password =$request->password;

            if(empty($password)){
                $result = $this->userModel->updateUser($id, $username, $email);
            } else {
                $result = $this->userModel->updateUser($id, $username, $email, $password);
            }

            if ($result) {
                $user = $this->userModel->user();
                View::redirectTo('/mvc/user');
            } else {
                echo "Gagal memperbarui user";
            }
        }
    }

    public function delete($id)
    {
        $result = $this->userModel->deleteUser($id);
        if ($result) {
            $user = $this->userModel->user();
            View::redirectTo('/mvc/user');
        } else {
            echo "Gagal menambahkan user";
        }
    }
}
?>