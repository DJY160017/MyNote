<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/9
 * Time: 13:35
 */

namespace App\Http\Controllers;


use App\Http\Service\NoteService;
use App\Http\Service\ShareService;
use App\Http\Service\UserService;
use App\Http\Util\IDReserver;
use Illuminate\Http\Request;

class ShareController extends Controller{

    private $noteService;

    private $userService;

    private $shareService;

    public function findFriend(){
        return view('share.userCheck');
    }

    public function getAllUser(){
        $this->noteService = new NoteService();
        $this->userService = new UserService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $array_user = $this->userService->getAllUser($userID);
        $result_users = array();
        for($i = 0;$i<count($array_user);$i++){
            $array = array();
            array_push($array,  $array_user[$i]['userID']);
            array_push($array,  $array_user[$i]['introduction']);
            array_push($array,  $array_user[$i]['mail']);
            array_push($array,  $this->noteService->countNote($array_user[$i]['userID']));
            array_push($result_users, $array);
        }
        return response()->json($result_users);
    }

    public function searchUser(Request $request){
        $this->userService = new UserService();
        $this->noteService = new NoteService();
        $info = $request->input('info');
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $array_user = $this->userService->searchUser($info,$userID);
        $result_users = array();
        for($i = 0;$i<count($array_user);$i++){
            $array = array();
            array_push($array,  $array_user[$i]['userID']);
            array_push($array,  $array_user[$i]['introduction']);
            array_push($array,  $array_user[$i]['mail']);
            array_push($array,  $this->noteService->countNote($array_user[$i]['userID']));
            array_push($result_users, $array);
        }
        return response()->json($result_users);
    }

    public function addFriend(Request $request){
        $this->shareService = new ShareService();
        $id_resever = new IDReserver();
        $friendID = $request->input('friendID');
        $userID = $id_resever->getUserID();
        $this->shareService->addFriend($userID, $friendID);
        return ['result'=>'success'];
    }

    public function removeFriend(Request $request){
        $this->shareService = new ShareService();
        $id_resever = new IDReserver();
        $friendID = $request->input('friendID');
        $userID = $id_resever->getUserID();
        $this->shareService->removeFriend($userID, $friendID);
        return ['result'=>'success'];
    }

    public function getAllFriend(){
        $this->shareService = new ShareService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        return response()->json($this->shareService->getFriends($userID));
    }

    public function searchFriend(Request $request){
        $this->shareService = new ShareService();
        $info = $request->input('info');
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $array_user = $this->shareService->searchFriends($userID,$info);
        return response()->json($array_user);
    }

    public function checkNote(Request $request){
        $friendID = $request->input('friendID');
        $notebookID = $request->input('notebookID');
        $noteID = $request->input('noteID');
        return view('share.noteCheck')->with([
            'friendID'=>$friendID,
            'notebookID'=>$notebookID,
            'noteID'=>$noteID
        ]);
    }

    public function getFriendNote(Request $request){
        $friendID = $request->input('friendID');
        $notebookID = $request->input('notebookID');
        $noteID = $request->input('noteID');
        $this->noteService = new NoteService();
        $note = $this->noteService->getOneNote($friendID,$notebookID,$noteID);
        return response()->json(array(
            'noteID'=>$note->getNoteID(),
            'notebookID'=>$note->getNotebookID(),
            'friendID'=>$note->getUserID(),
            'tagID'=>$note->getTagID(),
            'note'=>$note->getNote()
        ));
    }

    public function showFriendsNotes(){
        return view('share.friendNotelist');
    }

    public function getAllFriendsNote(){
        $this->shareService = new ShareService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $result = $this->shareService->getAllFriendNote($userID);
        return response()->json(array($result));
    }

}