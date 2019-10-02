 <?php
    class Post{
        //Database related variables
        private $conn;
        private $tableName = 'posts';

        //Table Properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $query=
            "SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                " . $this->tableName . " p
            LEFT JOIN 
                categories c
            ON
                p.category_id = c.id
            ORDER BY
                created_at DESC;
            ";
        
            //Preparing a statement to be executed
            $statement = $this->conn->prepare($query);

            $statement->execute();

            return $statement; 
        }


        //For Single Entry
        public function read_single(){
            $query=
            "SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                " . $this->tableName . " p
            LEFT JOIN 
                categories c
            ON
                p.category_id = c.id
            WHERE 
                p.id = ?
            ";
        
            //Preparing a statement to be executed
            $statement = $this->conn->prepare($query);
            $statement->bindParam(1,$this->id);
            $statement->execute();
            


            return $statement; 

        }

        //Create an Entry
        public function create(){
            $query=
                "INSERT INTO " . $this->tableName . "
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id 
                ";
            //Prepare Statement    
            $statement = $this->conn->prepare($query);

            //Clear Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //Bind Data
            $statement->bindParam('title',$this->title);
            $statement->bindParam('body',$this->body);
            $statement->bindParam('author',$this->author);
            $statement->bindParam('category_id',$this->category_id);


            //Execute Query
            if($statement->execute()){
                return true;
            }

            //Print Error if Something Goes Wrong
            printf("Error %s", $statement->error);

            return false;
        }
    }