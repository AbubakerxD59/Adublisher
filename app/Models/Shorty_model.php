<?php

class Shorty_model extends CI_Model
	{


	function __construct()
		{
		parent::__construct();
		}

	function index(){

	}
	function get_or_create($link)
	{
		$short_link = "";
		$result = $this->short_from_url($link);
		if($result){
			$short_link =  $result->url_short;
		}else{

			$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
			while($this->does_short_exist($short))
			{
				$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
			}

			$this->save_new_short($link, $short);
			$short_link = $short;
		}
		return $short_link;
	}

	function save_new_short($url, $alias)
    {
		$data = array(
			'url_short' => $alias,
			'url_link' => $url
		);
		$this->db->insert('short_urls', $data);
    }

	function short_from_url($url)
    {
		$alias = "";
		$this->db->select('url_short');
		$query = $this->db->get_where('short_urls', array('url_link' => $url), 1, 0);
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
    }

	function does_short_exist($alias)
    {
		$this->db->select('*');
		$query = $this->db->get_where('short_urls', array('url_short' => $alias), 1, 0);
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

    }
	
}
