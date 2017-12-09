<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 10:15
 */

namespace App\Http\Dao;


use App\Model\Notebook;
use Illuminate\Support\Facades\DB;

class NotebookDao{

    /**
     * @var string notebook数据库表名
     */
    private $tablename = 'notebook';

    /**
     * @var NoteDao 笔记的Dao层对象
     */
    private $noteDao;

    /**
     * NotebookDao constructor.
     */
    public function __construct(){
        $this->noteDao = new NoteDao();
    }


    /**
     * 用于获取指定用户，指定笔记本ID的笔记本
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return Notebook 所有笔记
     *
     */
    public function getNotebook($notebookID, $userID){
        $notebook_info = DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID]
        ])->get();

        if(sizeof($notebook_info->toArray()) == 0){
            return null;
        }

        $notebook = new Notebook();
        $notebook->setArray($notebook_info);
        return $notebook;
    }

    /**
     * 用于获取一个用户的所有笔记本ID
     *
     * @param $userID string 用户ID
     * @return array 所有笔记本ID
     *
     */
    public function getUserNotebookID($userID){
        $notebook_info = DB::table($this->tablename)->select('notebookID')->where([
            ['userID', '=', $userID]
        ])->get();
        $array_notebookID = $notebook_info->toArray();
        return $array_notebookID;
    }

    /**
     * 用于获取一个用户的所有笔记本
     *
     * @param $userID string 用户ID
     * @return array 所有笔记本
     *
     */
    public function getUserNotebook($userID){
        $notebook_info = DB::table($this->tablename)->where([
            ['userID', '=', $userID]
        ])->get();
        $array_notebook = $notebook_info->toArray();
        $result = array();
        foreach ($array_notebook as $item) {
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
     * 用于修改指定ID笔记本
     *
     * @param $notebook Notebook
     * @return boolean 是否成功添加
     */
    public function modifyNotebook($notebook){
        DB::table($this->tablename)->where([
            ['notebookID', '=', $notebook->getNotebookID()],
            ['userID', '=', $notebook->getUserID()]
        ])->update([
            'comment' => $notebook->getComment(),
            'createtime' => $notebook->getCreatetime()
        ]);
        return true;
    }

    /**
     * 用于添加笔记本
     *
     * @param $notebook Notebook
     * @return boolean 是否成功添加
     */
    public function addNotebook($notebook){
        DB::table($this->tablename)->insert([
            'notebookID' => $notebook->getNotebookID(),
            'userID' => $notebook->getUserID(),
            'comment' => $notebook->getComment(),
            'createtime' => $notebook->getCreatetime()
        ]);
        return true;
    }

    /**
     * 用于删除笔记本
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return boolean 是否成功删除
     *
     */
    public function removeNotebook($notebookID, $userID){
        DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['notebookID', '=', $notebookID]
        ])->delete();

        $result = $this->noteDao->removeOneNotebook($notebookID, $userID);
        return $result;
    }

    /**
     * @param $info string
     * @param $userID string
     * @return array
     */
    public function searchNotebook($info, $userID){
        $notebook_info = DB::table($this->tablename)->where([
            ['userID', '=', $userID],
            ['createtime', 'like', '%'.$info.'%']
        ])->orWhere([
            ['userID', '=', $userID],
            ['notebookID', 'like', '%'.$info.'%']
        ])->get();

        $array_notebook = $notebook_info->toArray();
        $result = array();
        foreach ($array_notebook as $item) {
            $array = get_object_vars($item);
            if(sizeof($array) != 0) {
                array_push($result, $array);
            }
        }
        return $result;
    }

}