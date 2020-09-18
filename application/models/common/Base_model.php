<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model
{
    protected $table = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function get($data = null,$limit = null)
    {
        if (! $data){
            $query = $this->db->get($this->table);
            return $query->result_array();

        }elseif($data == null && $limit == null){
            // $limit must be an int
            $this->db->limit($limit);
            $query = $this->db->get_where($this->table,$data);
            return $query->result_array();
        }
        else{
            // $data must be an array
            $query = $this->db->get_where($this->table,$data);
            return $query->result_array();
        }
    }

    public function order($field,$order,$where = null,$limit = null)
    {   
        switch ($order) {
            case 'A':
                $order = 'ASC';
                break;
            
            case 'D':
                $order = 'DESC';
                break;

            case 'R':
                $order = 'RANDOM';
                break;

            default:
                $this->db->limit($limit);
                $query = $this->db->get($this->table);
                return $query->result_array();
                break;
        }

        if($limit AND $where){
            $this->db->order_by($field,$order);
            $this->db->limit($limit);
            $query = $this->db->get_where($this->table,$where);
            return $query->result_array();
        }elseif($where){
            $this->db->order_by($field,($order));
            $query = $this->db->get_where($this->table,$where);
            return $query->result_array();
        }        
        else{
            $this->db->order_by($field,($order));
            $query = $this->db->get($this->table);
            return $query->result_array();
        }
    }

    public function insert($data = null)
    {
        $this->db->insert($this->table,$data);
    }

    public function delete($data = null)
    {
        if ((! $data == null) && is_array($data)){
            $this->db->delete($this->table,$data);
            return $this->db->affected_rows();

        }else{
            die('must include a parameter');
        }
    }

    public function update($where,$data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);    
    }

    public function count($where = null)
    {
        if ($where == null){
            $query = $this->db->count_all($this->table);
        return $query;
        }

        $this->db->where($where);
        $query = $this->db->count_all_results($this->table);
        return $query;
    }



//    helps to get a username when the id is passed in to the function

   public function get_username($column,$user_id){
        $this->db->from($this->table)
            ->where([$column => $user_id])
            ->join('users',$this->table.'.'.$column.'= users.id','LEFT');

        $query = $this->db->get();
       return $query->result_array();
   }

   public function join($table,$field,$default_table_field,$where = null)
   {
       if ($where == null){
           $this->db->select('*');
           $this->db->from($this->table);
           $this->db->join($table,$table.'.'.$field.'='.$this->table.'.'.$default_table_field);

           $query = $this->db->get();
           return $query->result_array();
       }

       $this->db->select('*');
       $this->db->where($where);
       $this->db->from($this->table);
       $this->db->join($table,$table.'.'.$field.'='.$this->table.'.'.$default_table_field);

       $query = $this->db->get();
       return $query->result_array();
   }

   public function join_multiple_order($table_field,$default_table_field,$order_field,$order,$where = null,$limit = null)
   {
// JOIN MULTIPLE TABLES AND ORDER THEM
// $table_field Must be an array

        switch ($order) {
            case 'A':
                $order = 'ASC';
                break;
            
            case 'D':
                $order = 'DESC';
                break;

            case 'R':
                $order = 'RANDOM';
                break;

            default:
                
                break;
        }
        

        if ($where == null){
            $this->db->select('*');
            $this->db->order_by($order_field,$order);
            $this->db->from($this->table);

            foreach ($table_field as $key => $value){
                $this->db->join($key,$key.'.'.$value.'='.$this->table.'.'.$default_table_field);
            }

            $query = $this->db->get();
            return $query->result_array();
        }elseif ($where != null){
            $this->db->select('*');
            $this->db->where($where);
            $this->db->order_by($order_field,$order);
            $this->db->from($this->table);
            
            foreach ($table_field as $key => $value){
                $this->db->join($key,$key.'.'.$value.'='.$this->table.'.'.$default_table_field);
            }

            $query = $this->db->get();
            return $query->result_array();
        }elseif($limit != null){
            $this->db->select('*');
            $this->db->where($where);
            $this->db->limit($limit);
            $this->db->order_by($order_field,$order);
            $this->db->from($this->table);
            
            foreach ($table_field as $key => $value){
                $this->db->join($key,$key.'.'.$value.'='.$this->table.'.'.$default_table_field);
            }

            $query = $this->db->get();
            return $query->result_array();
        }

        
   }
   
   public function join_multiple($table_field,$default_table_field,$where = null,$limit = null)
   {
// JOIN MULTIPLE TABLES AND ORDER THEM
// $table_field Must be an array
        if ($where == null){
            $this->db->select('*');
            $this->db->from($this->table);

            foreach ($table_field as $key => $value){
                $this->db->join($key,$key.'.'.$value.'='.$this->table.'.'.$default_table_field);
            }

            $query = $this->db->get();
            return $query->result_array();
        }elseif($where != null){
            $this->db->select('*');
            $this->db->where($where);
            $this->db->from($this->table);
            
            foreach ($table_field as $key => $value){
                $this->db->join($key,$key.'.'.$value.'='.$this->table.'.'.$default_table_field);
            }
        }elseif($limit != null){
            $this->db->select('*');
            $this->db->limit($limit);
            $this->db->where($where);
            $this->db->from($this->table);
            
            foreach ($table_field as $key => $value){
                $this->db->join($key,$key.'.'.$value.'='.$this->table.'.'.$default_table_field);
            }
        }

        $query = $this->db->get();
        return $query->result_array();
   }

   public function insert_return_field($data)
   {
        $this->db->insert($this->table,$data);
        $this->db->limit(1);
        $query = $this->db->get_where($this->table,$data);
        return $query->result_array();
   }

   public function increment($field,$where)
   {
        $this->db->set($field, $field. ' + 1',FALSE);
        $this->db->where($where);
        $this->db->update($this->table); 
   }

   public function increment_by($field,$value,$where)
   {
        $this->db->set($field, $field. ' + '. $value,FALSE);
        $this->db->where($where);
        $this->db->update($this->table); 
   }

   public function like($data)
   {
       $this->db->like($data);
       $query = $this->db->get($this->table);
       return $query->result_array();

   }

   public function sum($field,$where = null)
   {
        $this->db->select_sum($field);
        if($where):
            $this->db->where($where);
        endif;
        $query = $this->db->get($this->table)->row();
        return $query->$field;
   }

}