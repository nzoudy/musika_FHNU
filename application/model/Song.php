<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 06/02/15
 * Time: 01:20
 */

namespace Musika\model;

use Musika\core\Model;

class Song extends model {
    private $title;
    private $userid; // Foreign Key
    private $filepath;
    private $type; // Audio or Video
    private $gender; // RnB, Makossa, Rock, Techno
    private $created; // Creation date
    private $modified; // Modification date

    /**
     * Whenever controller is created, open a database connection too and load "the model".
     */
    function __construct($db)
    {
        parent::__construct($db);
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userid;
    }

    /**
     * @param mixed $UserId
     */
    public function setUserId($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param mixed $filepath
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return bool or an array of Song object
     */
    public function getAllSongs(){
        $songs = $this->getAll('song', array('id', 'artist', 'track', 'link'));

        if(!$songs || count($songs)== 0)
            return false;

        return $songs; // return array of Song objects
    }


    public function getAmountOfSong(){
        return $this->getAmount('song');
    }

    public function getSongById($song_id){
        $this->model->getSong($song_id);

    }

    public function save(){

    }

    public function delete($song_id){

    }



}