<?php
//require_once(APP.DS.'model'.DS.'Song.php');

use Musika\core\Controller;
use Musika\model\Song;
use Musika\model\User;

/**
 * Class Songs
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Songs extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/songs/index
     */
    public function index()
    {
        // set page title
        $this->view->title = "Songs";
        // getting all songs and amount of songs
        //$this->view->songs = $this->model->getAll('song', array('id', 'artist', 'track', 'link'));
        //$this->view->amount_of_songs = $this->model->getAmount('song');

        $songModel = new Song($this->db);

        // getting all songs and amount of songs
        $this->view->songs = $songModel->getAllSongs();
        $this->view->amount_of_songs = $songModel->getAmountOfSong();

        // load views. within the views we can echo out $songs and $amount_of_songs easily
        $this->view->render('index.php');
    }

    /**
     * ACTION: addSong
     * This method handles what happens when you move to http://yourproject/songs/addsong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a song" form on songs/index
     * directs the users after the form submit. This method handles all the POST data from the form and then redirects
     * the users back to songs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addSong($userid)
    {
        // New user instance
        $song = new Song($this->db);
        $user = new User($this->db);

        $emp = $user->isSigned();
        if (empty($emp)) {
            $this->view->redirect_to( URL. 'users/login');
            return;
        }

        $user->loadData();

        if($user->getUserId() != $userid){
            return;
        }

        // if we have POST data to create a new song entry
        if (isset($_POST["submit_add_song"]) && (isset($_FILES))) {

            // Move the file to the uploads folder
            $pathFile =  $this->checkandMoveFile($_FILES);

            if(!(bool)$pathFile){
                return;
            }
            // do addSong() in model/model.php
            $song->addSong($userid, $user->getFullName(), trim($_POST["track"]), $pathFile);
        }

        // where to go after song has been added
        $this->view->redirect_to( URL. 'users/');
    }

    /**
     * ACTION: deleteSong
     * This method handles what happens when you move to http://yourproject/songs/deletesong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a song" button on songs/index
     * directs the users after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the users back to songs/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $song_id Id of the to-delete song
     */
    public function deletesong($song_id)
    {

        // New user instance
        $song = new Song($this->db);
        $user = new User($this->db);

        $emp = $user->isSigned();
        if (empty($emp)) {
            $this->view->redirect_to( URL. 'users/login');
            return;
        }

        $user->loadData();

        // if we have an id of a song that should be deleted
        if (isset($song_id)){
            $tempSong = $song->getSongById($song_id, $user->getUserId());

            if(!empty($tempSong)){

                if($song->deleteSong($song_id, $user->getUserId())){
                    // delete file inside the database
                    if (file_exists($tempSong->link)) {
                        unlink($tempSong->link);
                    }
                }
            }

        }

        // where to go after song has been deleted
        header('location: ' . URL . 'users/');
    }

     /**
     * ACTION: editSong
     * This method handles what happens when you move to http://yourproject/songs/editsong
     * @param int $song_id Id of the to-edit song
     */
    public function editSong($song_id)
    {
        // if we have an id of a song that should be edited
        if (isset($song_id)) {
            // set page title
            $this->view->title = "Edit song";
            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the users to an error page or similar
            // do getSong() in model/model.php
            $this->view->song = $this->model->getSong($song_id);

            // load views. within the views we can echo out $song easily
            $this->view->render('edit.php');

        } else {
            // redirect users to songs index page (as we don't have a song_id)
            header('location: ' . URL . 'songs/index');
        }
    }
    
    /**
     * ACTION: updateSong
     * This method handles what happens when you move to http://yourproject/songs/updatesong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a song" form on songs/edit
     * directs the users after the form submit. This method handles all the POST data from the form and then redirects
     * the users back to songs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateSong()
    {
        // if we have POST data to create a new song entry
        if (isset($_POST["submit_update_song"])) {
            // do updateSong() from model/model.php
            $this->model->updateSong($_POST["artist"], $_POST["track"],  $_POST["link"], $_POST['song_id']);
        }

        // where to go after song has been added
        header('location: ' . URL . 'songs/index');
    }

    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $amount_of_songs = $this->model->getAmount('song');

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $amount_of_songs;
    }


    private function checkandMoveFile($file){

        if (($file["file"]["type"] == "audio/mp3") && ($file["file"]["size"] < 6144000)) {
            if ($file["file"]["error"] > 0) {
               return false;
            } else {
                if (file_exists("upload/" . $file["file"]["name"])) {
                    return false;
                } else {
                    move_uploaded_file($file["file"]["tmp_name"], "upload/" .$file["file"]["name"]);
                    return "upload/" . $file["file"]["name"];
                }
            }

        } else{
            return false;
        }
    }



}