<?php
//CLASS get news
class news  
{
	//You can change default values
	public $query			 		= '';					 		//Search query
	public $search			 		= 'moderate';			 		//Acceptable is strict, moderate and relative
	public $limit 					= 10;							//Total number of results, max 50
	public $start 					= 0;							//First result
	public $id		 				= NULL;							//ID of requested news
	public $catid		 			= NULL;							//Category id to retrieve
	public $sort		 			= 'date';						//Sort results by date, title or id
	public $order		 			= 'DESC';						//Sort order, DESC OR ASC
	public $type		 			= 'all';						//Type of search result, all, news, title
	
	public $server					= 'http://news.tnt.ba/api/';
	
	//private values
	private $user		 			= '';						 	//Username
	private $pass			 		= '';					 		//Password
	
	public function __construct($u, $p) 
	{
		$this->user = $u;
		$this->pass = $p;
    }
	
	public function get()
	{
		$ctx = stream_context_create(array( 
			 'http' => array( 
				'timeout' => 10 
				) 
			) 
		);
		
		$get = "&get=news";
		$limit = '&limit='.$this->limit;
		$start = '&start='.$this->start;
		$query = '&q='.$this->query;
		$search = '&search='.$this->search;
		$id = '&id='.$this->id;
		$catid = '&catid='.$this->catid;
		$type = '&type='.$this->type;
		$sort = '&sort='.$this->sort;
		$order = '&order='.$this->order;
		
		$res = file_get_contents($this->server.'?user='.$this->user.'&pass='.$this->pass.$get.$limit.$start.$query.$search.$id.$catid.$type.$sort.$order, 0, $ctx);
		return json_decode($res, true);
	}
	
	public function getCategories()
	{
		$ctx = stream_context_create(array( 
			 'http' => array( 
				'timeout' => 10 
				) 
			) 
		);
		
		$get = "&get=categories";
		
		$res = file_get_contents($this->server.'?user='.$this->user.'&pass='.$this->pass.$get, 0, $ctx);
		return json_decode($res, true);
	}
}  
?>