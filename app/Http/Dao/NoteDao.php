<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 10:14
 */

namespace App\Http\Dao;


use App\Model\Note;
use Illuminate\Support\Facades\DB;

class NoteDao{

    /**
     * @var string note数据库表名
     */
    private $tablename = 'note';

    /**
     * 用于获取指定用户，指定笔记本，指定笔记ID的笔记
     *
     * @param $userID string 用户ID
     * @param $notebookID string 笔记本ID
     * @param $noteID string 笔记ID
     * @return Note 笔记实体
     *
     */
    public function getOneNote($userID, $notebookID, $noteID){
        $note_info = DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID],
            ['noteID', '=', $noteID]
        ])->get();

        if(sizeof($note_info->toArray()) == 0){
            return null;
        }

        $note = new Note();
        $note->setArray($note_info);
        return $note;
    }

    /**
     * 用于获取指定用户，指定笔记本ID的所有笔记
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return array 所有笔记
     *
     */
    public function getOneNotebook($notebookID, $userID){
        $note_info = DB::table($this->tablename)->where([
            ['notebookID', '=', $notebookID],
            ['userID', '=', $userID]
        ])->get();
        $array_note = $note_info->toArray();
        $result = array();
        foreach ($array_note as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }

        if(sizeof($result) == 0){
            return null;
        }
        return $result;
    }

    /**
     * 根据tag获取指定用户的所有笔记
     *
     * @param $userID string 用户ID
     * @param $tagIDs array 标签ID
     * @return array 所有笔记
     *
     */
    public function getNoteByTag($userID, $tagIDs){
        $condition = array();
        array_push($condition, ['userID', '=', $userID]);
        foreach ($tagIDs as $tagID){
            array_push($condition, ['tagID', 'like', '%'.$tagID.'%']);
        }

        $note_info = DB::table($this->tablename)->where($condition)->get();
        $array_note = $note_info->toArray();
        $result = array();
        foreach ($array_note as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }

        if(sizeof($result) == 0){
            return null;
        }
        return $result;
    }

    /**
     * 用于获取指定笔记本ID， 用户ID的所有笔记ID
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return array
     */
    public function getNoteID($notebookID, $userID){
        $info = DB::table($this->tablename)->where([
            ['notebookID','=',$notebookID],
            ['userID','=', $userID]
        ])->get(['noteID']);
        $array = $info->toArray();
        $result = array();
        foreach ($array as $item){
            $noteIDs = get_object_vars($item);
            if(sizeof($noteIDs) != 0){
                array_push($result, $noteIDs);
            }
        }

        if(sizeof($result) == 0){
            return null;
        }
        return $result;
    }

    /**
     * 获得一个用户的所有笔记
     *
     * @param $userID string
     * @return array
     */
    public function getUserAllNote($userID){
        $note_info = DB::table($this->tablename)->where([
            ['userID', '=', $userID]
        ])->get();
        $array_note = $note_info->toArray();
        $result = array();
        foreach ($array_note as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }

    /**
     * 用户添加笔记
     *
     * @param $note Note
     * @return boolean 是否添加成功
     */
    public function addNote($note){
        DB::table($this->tablename)->insert([
            'noteID' => $note->getNoteID(),
            'notebookID' => $note->getNotebookID(),
            'userID' => $note->getUserID(),
            'tagID' => $note->getTagID(),
            'note' => $note->getNote(),
            'comment' => $note->getComment(),
            'createtime' => $note->getCreatetime()
        ]);
        return true;
    }

    /**
     * 用于修改指定note的内容
     *
     * @param $note Note
     * @return boolean 是否成功修改
     */
    public function modifyNote($note){
        DB::table($this->tablename)->where([
            ['noteID', '=', $note->getNoteID()],
            ['notebookID', '=', $note->getNotebookID()],
            ['userID', '=', $note->getUserID()]
        ])->update([
            'tagID' => $note->getTagID(),
            'note' => $note->getNote(),
            'comment' => $note->getComment(),
            'createtime' => $note->getCreatetime()
        ]);
        return true;
    }

    /**
     * 用于删除笔记
     *
     * @param $userID string 用户ID
     * @param $notebookID string 笔记本ID
     * @param $noteID string 笔记ID
     * @return boolean 是否成功删除笔记
     *
     */
    public function removeNote($userID, $notebookID, $noteID){
        DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID],
            ['noteID', '=', $noteID]
        ])->delete();
        return true;
    }

    /**
     * 用于批量删除笔记
     *
     * @param $ids array 笔记ID集合
     * @return boolean 是否成功删除
     */
    public function removeNotes($ids){
        foreach ($ids as $id){
            DB::table($this->tablename)->where([
                ['userID', '=', $id['userID']],
                ['notebookID', '=', $id['notebookID']],
                ['noteID', '=', $id['noteID']]
            ])->delete();
        }
        return true;
    }

    /**
     * 用于删除笔记本
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 笔记ID
     * @return boolean 是否成功删除笔记本
     */
    public function removeOneNotebook($notebookID, $userID){
        DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID]
        ])->delete();
        return true;
    }

    /**
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return int 笔记本笔记数量
     */
    public function countNotebook($notebookID, $userID){
        $num = DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID]
        ])->count();
        return $num;
    }

    /**
     * @param $userID string 用户ID
     * @return int 笔记本笔记数量
     */
    public function countNote($userID){
        $num = DB::table($this->tablename)->where([
            ['userID', '=', $userID],
        ])->count();
        return $num;
    }

    /**
     * @param $info string
     * @param $notebookID string
     * @param $userID string
     * @return array
     */
    public function searchNote($info,$notebookID,$userID){
        $note_info = DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID],
            ['createtime', 'like', '%'.$info.'%']
        ])->orWhere([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID],
            ['noteID', 'like', '%'.$info.'%']
        ])->get();

        $array_note = $note_info->toArray();
        $result = array();
        foreach ($array_note as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }

    /**
     * @param $info string
     * @param $userID string
     * @return array
     */
    public function searchNoteByTag($info, $userID){
        $note_info = DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['tagID', 'like', '%'.$info.'%']
        ])->get();

        $array_note = $note_info->toArray();
        $result = array();
        foreach ($array_note as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }
}