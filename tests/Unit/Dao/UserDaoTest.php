<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 22:10
 */

namespace Tests\Unit\Dao;

use App\Http\Dao\UserDao;
use App\Model\User;
use Tests\TestCase;

class UserDaoTest extends TestCase {

    private $userDao;

    public function testAdd(){
        $this->userDao = new UserDao();

        $path = public_path('images/default.jpg');
        $size = filesize($path);
        $file = fopen($path, 'r');
        $img = fread($file, $size);
        $img_base64 = 'data:' . $size['mime'] . ';base64,' . chunk_split(base64_encode($img));
        fclose($file);

        $user1 = new User();
        $user1->setUserID("harvey");
        $user1->setPassword("123456");
        $user1->setHeadportrait($img_base64);
        $user1->setMail('123456@qq.com');
        $user1->setIntroduction("good");

        $this->userDao->add($user1);

//        $user2 = new User();
//        $user2->setUserID("chris");
//        $user2->setPassword("123456");
//        $user2->setHeadportrait($img_base64);
//        $user2->setMail('123456@qq.com');
//        $user2->setIntroduction("good");
//
//        $this->userDao->add($user2);
    }

    public function testGet(){
        $this->userDao = new UserDao();
        $user = $this->userDao->get('byron');
        $this->assertEquals('byron', $user->getUserID());
        $this->assertEquals('123456', $user->getPassword());
        $this->assertEquals('123456@qq.com', $user->getMail());
        $this->assertEquals('good', $user->getIntroduction());
    }

    public function testModify(){
        $this->userDao = new UserDao();
        $path = public_path('images/default.jpg');
        $size = filesize($path);
        $file = fopen($path, 'r');
        $img = fread($file, $size);
        fclose($file);

        $user = new User();
        $user->setUserID("byron");
        $user->setPassword("1234560987654321");
        $user->setHeadportrait($img);
        $user->setMail('123456@163.com');
        $user->setIntroduction("good,hi hi");

        $this->userDao->modify($user);
    }

}
