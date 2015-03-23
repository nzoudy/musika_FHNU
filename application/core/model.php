<?php
namespace Musika\core;


class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Get all songs from database
     */
    public function getAll($table, $cols=null)
    {
       // $sql = "SELECT id, artist, track, link FROM {$table}";
        if(is_array($cols)){
            $strcols =  implode(",", $cols);
            $sql = "SELECT {$strcols} FROM {$table}";

        }elseif(!is_array($cols) && $cols!= null){
            $sql = "SELECT {$cols} FROM {$table}";
        }else{
            $sql = "SELECT  *  FROM {$table}";
        }
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Add a song to database
     * TODO put this explanation into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     */
    public function add($artist, $track, $link)
    {
        $sql = "INSERT INTO song (artist, track, link) VALUES (:artist, :track, :link)";
        $query = $this->db->prepare($sql);
        $parameters = array(':artist' => $artist, ':track' => $track, ':link' => $link);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Delete a song in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $song_id Id of song
     */
    public function delete($song_id)
    {
        $sql = "DELETE FROM song WHERE id = :song_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':song_id' => $song_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get a song from database
     */
    public function get($song_id)
    {
        $sql = "SELECT id, artist, track, link FROM song WHERE id = :song_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':song_id' => $song_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Update a song in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $song_id Id
     */
    public function update($artist, $track, $link, $song_id)
    {
        $sql = "UPDATE song SET artist = :artist, track = :track, link = :link WHERE id = :song_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':artist' => $artist, ':track' => $track, ':link' => $link, ':song_id' => $song_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/SongsController.php for more)
     */
    public function getAmount($table)
    {
        $sql = "SELECT COUNT(id) AS amount FROM {$table}";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount;
    }

    /**
     * Use to check if the value already exist in database
     * @return true or false
     */
    public function isUnique($table, $value, $col=null){

        echo $value;

       if($col == null) {
            return false;
       }
        $sql = "SELECT  {$col} FROM {$table}";

        $sql .= " WHERE {$col} = :email " ;

        $query = $this->db->prepare($sql);

        $parameters = array(':email' => $value);

        $query->execute($parameters);

        print_r( $query->fetchAll());

        return count($query->fetchAll()) > 0 ;
    }

    /**
     * Create a new user
     */
    public function addUser($table, $data){
        $keys = array_keys($data);
        $fields = '`'.implode('`, `',$keys).'`';
        $placeholder = '';
        for ( $i = 0; $i < count($keys); $i++){
            $placeholder .= '?';
            if($i != (count($keys)-1)){
                $placeholder .= ', ';
            }
        }
        $sql = "INSERT INTO {$table}  ({$fields}) VALUES ({$placeholder})" ;
        $query = $this->db->prepare($sql);
        return $query->execute(array_values($data));
    }

    /**
     * Get the last id
     */

    public function getLastId($table){
        $sql = "SELECT id FROM {$table}  ORDER BY id DESC LIMIT 1" ;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
}