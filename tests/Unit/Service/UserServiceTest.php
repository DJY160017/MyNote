<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/14
 * Time: 21:46
 */

namespace Tests\Unit\Service;

use App\Exceptions\PasswordInvalidException;
use App\Exceptions\UserExistedException;
use App\Exceptions\UserNotExistException;
use App\Http\Service\UserService;
use App\Model\User;
use Tests\TestCase;

class UserServiceTest extends TestCase{

    private $userService;

    public function testLogin(){
        $this->userService = new UserService();
        try {
            $this->assertEquals(true, $this->userService->login('cbudcbhfcbf', '1234567890'));
        }  catch (UserNotExistException $e) {
            echo 'hhhhhhhhhhhhh';
        } catch (PasswordInvalidException $e1){
            echo 'eeeeeeeeeeeee';
        }
    }

    public function testLogin1(){
        $this->userService = new UserService();
        $userinfo = $this->userService->get('byron');
        try {
            $this->assertEquals('123456@163.com',$userinfo->getMail());
        }  catch (UserNotExistException $e) {
            echo 'hhhhhhhhhhhhh';
        } catch (PasswordInvalidException $e1){
            echo 'eeeeeeeeeeeee';
        }
    }

    public function testSignUp(){
        $this->userService = new UserService();
        $path = public_path('images/default.jpg');
        $size = filesize($path);
        $file = fopen($path, 'r');
        $img = fread($file, $size);
        fclose($file);

        $user1 = new User();
        $user1->setUserID("harvey");
        $user1->setPassword("1234567890");
        $user1->setHeadportrait($img);
        $user1->setMail('151250032@smail.nju.edu.cn');
        $user1->setIntroduction("I'm a student");

        try {
            $this->userService->signUp($user1);
        } catch (UserExistedException $e) {
            echo $e->getMessage();
        }
    }

    public function testModify(){
        $this->userService = new UserService();
        $path = public_path('images/default.jpg');
        $size = filesize($path);
        $file = fopen($path, 'r');
        $img = fread($file, $size);
        fclose($file);

        $user1 = new User();
        $user1->setUserID("Byron Dong");
        $user1->setPassword("qwertyuiop");
        $user1->setHeadportrait($img);
        $user1->setMail('151250032@smail.nju.edu.cn');
        $user1->setIntroduction("I'm a student");

        try {
            $this->userService->modifyInfo($user1);
        } catch (UserNotExistException $e) {
            echo $e->getMessage();
        }
    }
}
