<?php

class BaseModel {
    public $db;
    public $model;
    private $where;
    private $limit;
	private $from;
    private $join;
    private $order;
	private $select = "SELECT *";
	private $custom_query = null;
    private $pdo;

    public function __construct(){
        $this->db = Db::Instance();
    }


    public function load($modelname){
        //load model
        $modelpath = "src/models/".$modelname.".php";

        //check if model exists
        if(file_exists($modelpath)){
            require_once $modelpath;
            $this->$modelname = new $modelname;

            return true;
        }

        return false;

    }

    public function select($select){
        if(isset($select) && is_string($select))
            $this->select = "SELECT ".$select;

        if(is_array($select) && !empty($select)){
            $this->select = "SELECT ".implode(",", $select);
        }

    }

    public function where($where=array()){
        // $this->where = "WHERE ".$where;	
        if(empty($where))
			throw new Exception("Where clause is empty");

		$i = 1;
		$z = 0;

		//total where clause amount
		$where_count = count($where);

		foreach($where AS $whereas => $value):
		// while($z < $where_count):
			if($i == $where_count)
				$this->where .= $whereas." =? ";
			else
				$this->where .= $whereas." =? AND ";

			$this->bind_param[$i] = $value;
			$i++;
			$z++;
		// endwhile;
		endforeach;

    }

	public function from($table){
		if(is_string($table))
			$this->from = $table;
	}

    public function limit($limit){
        $this->limit = "Limit ".$limit;

    }

    public function join($table, $join_on, $position="left"){
        $this->join = strtoupper($position)." JOIN ".$table." ON ".$join_on;

    }

    public function orderby($order){
        $this->order = "ORDER BY ".$order;

    }

    public function execute(){

		if(is_null($this->custom_query)){
			$this->query = $this->select;

            if(!$this->from)
                throw new Exception("DB: Have not selected a table");
            

            $this->query .= " FROM ".$this->from;

            if($this->join)
                $this->query .= $this->join;

            if($this->where)
                $this->query .= " WHERE ".$this->where;

            if($this->order)
                $this->query .= " ORDER BY ".$this->order;
        
            // $db = $this->pdo->prepare($this->query);
            $this->pdo = $this->db->pdo->prepare($this->query);

            //bind the values from where clause
            if(!empty($this->bind_param)){
                foreach($this->bind_param AS $key => $params):
                    if(is_numeric($params)){
                        $this->pdo->bindValue($key, $params, PDO::PARAM_INT);
                    } else {
                        $this->pdo->bindValue($key, $params, PDO::PARAM_STR);
                    }

                endforeach;

            }

            // $db->execute();
            $this->pdo->execute();
            //custom query
        } else {
            // error_log("query: ".var_export($this->query, true));
            // $db = $this->db->pdo->query($this->query);
            $this->pdo = $this->db->pdo->query($this->query);
        }


    }


	public function query($query){

		if(!is_string($query))
			throw new Exception("query is not valid: ".$query);

		$this->custom_query = true;
		$this->query = $query;

	}

    public function fetchAll(){
        return $this->pdo->fetchAll();
    }

    public function fetchOne(){
        return $this->pdo->fetch(PDO::FETCH_ASSOC);
    }
   
}
