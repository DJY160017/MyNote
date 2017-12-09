<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/4
 * Time: 13:19
 */

namespace App\Http\Controllers;


use App\Exceptions\PasswordInvalidException;
use App\Exceptions\UserExistedException;
use App\Exceptions\UserNotExistException;
use App\Http\Service\UserService;
use App\Http\Util\IDReserver;
use App\Http\Util\Matcher;
use App\Http\Util\Safer;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller{

    private $userService;

    public function index(){
        return view('user.index');
    }

    public function showProfile(){
        return view('user.profile');
    }

    public function uploadHead(Request $request){
        $this->userService = new UserService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $userinfo = $this->userService->get($userID);

        $img = $request->input('image');
        $userinfo->setHeadportrait($img);
        $this->saveHead($img);
        $this->userService->modifyInfo($userinfo);
        return response()->json(array(
            'result'=>'success'
        ));
    }

    public function modifyPassword(Request $request){
        $this->userService = new UserService();
        $id_resever = new IDReserver();
        $safer = new Safer();
        $userID = $id_resever->getUserID();
        $userinfo = $this->userService->get($userID);

        $password = $request->input('password');
        $userinfo->setPassword($safer->encode($password));
        $this->userService->modifyInfo($userinfo);
        return response()->json(array(
            'result'=>'success'
        ));
    }

    public function modifyProfile(Request $request){
        $this->userService = new UserService();
        $matcher = new Matcher();
        $mail = $request->input('mail');
        $introduction = $request->input('introduction');
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $userinfo = $this->userService->get($userID);

        if($matcher->mailMatcher($mail)){
            $userinfo->setMail($mail);
            $userinfo->setIntroduction($introduction);
            $this->userService->modifyInfo($userinfo);
            return ['result'=>'success'];
        }else{
            return ['result'=>'邮箱格式不正确'];
        }
    }

    public function getProfileInfo(){
        $this->userService = new UserService();
        $id_resever = new IDReserver();
        $userinfo = $this->userService->get($id_resever->getUserID());
        return response()->json(array(
            'mail'=>$userinfo->getMail(),
            'introduction'=>$userinfo->getIntroduction(),
            'password'=>$userinfo->getPassword()
        ));
    }

    public function login(Request $request){
        $this->userService = new UserService();
        $id_resever = new IDReserver();
        $safer = new Safer();
        $account = $request->input("account");
        $password = $request->input("password");
        try {
            $this->userService->login($account, $safer->encode($password));
            $id_resever->setUserID($account);
            $userinfo = $this->userService->get($account);
            $this->saveHead($userinfo->getHeadportrait());
            return ['result' => 'success'];
        } catch (UserNotExistException $e) {
                return ['result' => '该用户不存在'];
        } catch (PasswordInvalidException $e1){
            return  ['result' => '密码不正确'];
        }
    }

    public function signUp(Request $request){
        $this->userService = new UserService();
        $id_resever = new IDReserver();
        $safer = new Safer();
        $account = $request->input("account");
        $password = $request->input("password");
        $user = new User();
        $path = public_path('images/default.jpg');
        $size = filesize($path);
        $file = fopen($path, 'r');
        $img = fread($file, $size);
        fclose($file);

        $user->setUserID($account);
        $user->setPassword($safer->encode($password));
        $user->setHeadportrait($img);
        $user->setMail("");
        $user->setIntroduction("");
        try {
            $this->userService->signUp($user);
            $id_resever->setUserID($account);
            return ['result'=>'success'];
        } catch (UserExistedException $e) {
            return ['result'=>'该用户名已存在'];
        }
    }

    /**
     * @param $img string base64编码
     */
    private function saveHead($img){
        $img_array = explode(',',$img);
        $base_img = '';
        if(count($img_array) != 2){
            for($i = 1;$i<count($img_array);$i++){
                $base_img = $base_img.$img_array[$i];
            }
        } else{
            $base_img = $img_array[1];
        }

        $path = public_path('images/default.jpg');
        $file = fopen($path, 'wb');
        fwrite($file, base64_decode($base_img));
        fclose($file);
    }
}