<?php
require_once 'Database.php';

class Books{
    private $db = "";   
    public $allFiles = array();
    
    public function __construct() {
        $dbinstance = Database::getInstance();
        $this->db = $dbinstance->getConnection();
    }
    
    public function listFiles($dir = ""){
        $folders = scandir($dir);

        unset($folders[array_search('.', $folders, true)]);
        unset($folders[array_search('..', $folders, true)]);

        // prevent empty ordered elements
        if (count($folders) < 1){
            return false;
        }
        
        foreach($folders as $fname){
            if(is_dir($dir.'/'.$fname)){
                $this->listFiles($dir.'/'.$fname);
            }else{
                array_push($this->allFiles, $dir.'/'.$fname);
            }
        }
    }


    public function readXML() {
        $this->listFiles('library');  

        foreach ($this->allFiles as $key => $xml_file) {
            $xml = simplexml_load_file($xml_file);
            $json_string = json_encode($xml);    
            $result_array = json_decode($json_string, TRUE);
            
            $dataQuery = "SELECT book_catnum FROM books WHERE book_catnum=:catnum";
            $res = $this->db->prepare($dataQuery);

            foreach ($result_array['book'] as $book) {
                $res->bindParam(':catnum', intval($book['catnum']));
                $res->execute();
                
                if($res->rowCount() > 0){
                    $data = array(
                        ':catnum'   => intval($book['catnum'])
                    );
                    $updateDate = "UPDATE books SET book_add_date = current_timestamp WHERE book_catnum = :catnum";
                    $this->db->prepare($updateDate)->execute($data);
                    
                }else{
                    $data = array(
                        ':catnum' => intval($book['catnum']),
                        ':author' => $book['author'],
                        ':name' => $book['name'],
                    );
                    $insertData = "INSERT INTO books (book_catnum, book_author, book_name, book_add_date) VALUES (:catnum, :author, :name, current_timestamp)";
                    $this->db->prepare($insertData)->execute($data);
                }
            }
        }
           
    }
    
    public function searchBook($author) {
        $dataQuery = "SELECT * FROM books WHERE book_author = :author";
        $res = $this->db->prepare($dataQuery);
        $res->bindParam(':author', $author);
        $res->execute();
        return $res->fetchAll();
    }
    
    
}