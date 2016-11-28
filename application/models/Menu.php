<?php

define('REST_SERVER', 'http://backend.local');  // the REST server host
define('REST_PORT', $_SERVER['SERVER_PORT']);   // the port you are running the server on

// Menu class
class Menu extends MY_Model
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['curl', 'format', 'rest']);
    }

    public function rules()
    {
        $config = [
            ['field' => 'id', 'label' => 'Menu code', 'rules' => 'required|integer'],
            ['field' => 'name', 'label' => 'Item name', 'rules' => 'required'],
            ['field' => 'description', 'label' => 'Item description', 'rules' => 'required|max_length[256]'],
            ['field' => 'price', 'label' => 'Item price', 'rules' => 'required|decimal'],
            ['field' => 'picture', 'label' => 'Item picture', 'rules' => 'required'],
            ['field' => 'category', 'label' => 'Menu category', 'rules' => 'required'],
        ];

        return $config;
    }

    public function all()
    {
        $this->rest->initialize(array('server' => REST_SERVER));
        $this->rest->option(CURLOPT_PORT, REST_PORT);

        return $this->rest->get('/maintenance');
    }

    // Retrieve an existing DB record as an object
    public function get($key, $key2 = null)
    {
        $this->rest->initialize(array('server' => REST_SERVER));
        $this->rest->option(CURLOPT_PORT, REST_PORT);

        return $this->rest->get('/maintenance/item/id/'.$key);
    }


    function create()
    {
        $names = ['id','name','description','price','picture','category'];
        $object = new StdClass;
        foreach ($names as $name)
            $object->$name = "";
        return $object;
    }

    function delete($key, $key2 = null)
    {
        $this->rest->initialize(array('server' => REST_SERVER));
        $this->rest->option(CURLOPT_PORT, REST_PORT);
        return $this->rest->delete('/maintenance/item/id/' . $key);
    }

    function exists($key, $key2 = null)
    {
        $this->db->where($this->_keyField, $key);
        $query = $this->db->get($this->_tableName);
        if ($query->num_rows() < 1)
            return false;
        return true;
    }

    function update($record)
    {
        $this->rest->initialize(array('server' => REST_SERVER));
        $this->rest->option(CURLOPT_PORT, REST_PORT);
        $retrieved = $this->rest->put('/maintenance/item/id/' . $record['code'], $record);
    }

    function add($record)
    {
        $this->rest->initialize(array('server' => REST_SERVER));
        $this->rest->option(CURLOPT_PORT, REST_PORT);
        $retrieved = $this->rest->post('/maintenance/item/id/' . $record['code'], $record);
    }



}
