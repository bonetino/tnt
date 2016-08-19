<?php
//CLASS show messages
class pagination  
{
	//You can change default values
	public $iconcolor_bg 			= array(255, 255, 255, 127); 	//Back color (R, G, B, A);
	public $iconcolor_normal 		= array(51, 51, 51, 0); 		//Normal icon color (R, G, B, A);
	public $iconcolor_hover 		= array(235, 7, 98, 0); 		//Hover icon color (R, G, B, A);
	public $iconcolor_disabled 		= array(225, 226, 229, 0); 		//Disabled icon color (R, G, B, A);
	public $icons 					= "images/pagination.png";		//Icons image file
	public $backcolor 				= "#FFFFFF";					//Container back color
	public $margin_top 				= 0;							//Top space of container
	public $margin_bottom 			= 0;							//Bottom space of container
	public $margin_left 			= 0;							//Left space of container
	public $margin_right 			= 0;							//Right space of container
	public $padding_left 			= 5;							//Inner space of container
	public $padding_right 			= 5;							//Inner space of container
	public $padding_top 			= 5;							//Inner space of container
	public $padding_bottom 			= 5;							//Inner space of container
	public $align 					= "left";						//Inner horizontal aligment
	public $valign 					= "middle";						//Inner vertical aligment
	
	//Do not change anything below
	public $total;
	public $perpage;
	public $firstpage;
	public $prevpage;
	public $allpage;
	public $nextpage;
	public $lastpage;
	public $shown;
	public $pid;
	public $fullurl;
	public $url;
	public $pages;
	
	//style
	public $css = '<style type="text/css">
	.class_pagination {
		background:url({ICONS_IMAGE}) no-repeat;
	}
	
	#class_left {
		width:20px;
		height:21px;
		background-position: 0px 2px;
		cursor:pointer;
	}
	#class_left:hover {
		background-position: -25px 2px;
	}
	#class_left_off {
		width:20px;
		height:21px;
		background-position: -50px 2px;
	}
	#class_previous {
		width:25px;
		height:21px;
		background-position: -150px 2px;
		cursor:pointer;
	}
	#class_previous:hover {
		background-position: -175px 2px;
	}
	#class_previous_off {
		width:25px;
		height:21px;
		background-position: -200px 2px;
	}
	#class_pages {
		padding-right:7px;
		height:20px;
	}
	.class_page {
		width:25px;
		height:21px;
		color:#FFF;
		text-shadow: 0 1px 1px #000;
		text-align:center;
		background:#363334;
		font-weight:bold;
		cursor:pointer;
	}
	.class_page_off {
		width:25px;
		height:21px;
		color:#FFF;
		text-shadow: 0 1px 1px #000;
		text-align:center;
		font-weight:bold;
		background:#EB0762;
	}
	.class_page:hover {
		background:#EB0762;
	}
	.class_page_dots {
		width:25px;
		height:21px;
		color:#FFF;
		text-shadow: 0 1px 1px #000;
		text-align:center;
		background:#363334;
		font-weight:bold;
	}
	#class_next {
		width:25px;
		height:21px;
		background-position: -225px 2px;
		cursor:pointer;
	}
	#class_next:hover {
		background-position: -250px 2px;
	}
	#class_next_off {
		width:25px;
		height:21px;
		background-position: -275px 2px;
	}
	#class_right {
		width:20px;
		height:21px;
		background-position: -75px 2px;
		cursor:pointer;
	}
	#class_right:hover {
		background-position: -100px 2px;
	}
	#class_right_off {
		width:20px;
		height:21px;
		background-position: -125px 2px;
	}
	</style>';
	
	public function __construct($d, $t, $p = 10) 
	{
		$this->pid = $d;
		$this->total = $t;
		$this->perpage = $p;
		
		$this->GetFullUrl();
		$this->createIcons();
		if ($this->UrlHaveParams(preg_replace("/(&|\?)".$this->pid."=[a-zA-Z0-9]*/", "", $this->fullurl))) {$s = "&";} else {$s = "?";}
		$this->url = preg_replace("/(&|\?)".$this->pid."=[a-zA-Z0-9]*/", "", $this->fullurl).$s.$this->pid."=";
    }
	
	public function addCss()
	{
		$this->css = str_replace("{ICONS_IMAGE}", $this->icons, $this->css);
		echo $this->css;
	}
	
	public function GetFullUrl()
	{
		if (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false)
		{
			$this->fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		else
		{
			if (strpos($_SERVER['REQUEST_URI'], '?') !== false)
			{
				$this->fullurl = "http://".$_SERVER['HTTP_HOST'].str_replace("?", "index.php?", $_SERVER['REQUEST_URI']);	
			}
			else
			{
				$this->fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."index.php";	
			}
		}
	}
	
	public function UrlHaveParams($url) 
	{
		$parsed = parse_url($url);
		if(empty($parsed["query"])) {return false;} else {return true;}
	}
	
	public function getPages()  
    {
		$pages = floor($this->total/$this->perpage);
		if (($pages*$this->perpage) < $this->total) {$pages++;}
		$this->pages = $pages;
		return $pages;
	}
	
	public function get($page = 1)  
    {
		if (empty($page)) {$page = 1;}
		  
		$pages = floor($this->total/$this->perpage);
		if (($pages*$this->perpage) < $this->total) {$pages++;}
		$this->pages = $pages;
		
		//shown
		if (($page*$this->perpage) > $this->total) {$end = $this->total;} else {$end = ($page*$this->perpage);}
		$start = (($page*$this->perpage)-$this->perpage+1);
		$this->shown = $start." - ".$end;
		
		//first
		if ($page == 1)
		{
			$this->firstpage = "<td id=\"class_left_off\" class=\"class_pagination\">&nbsp;</td>";
		}
		else
		{
			$this->firstpage = "<td id=\"class_left\" class=\"class_pagination\" onclick=\"javascript: window.location = '".$this->url."1';\">&nbsp;</td>";
		}
		
		//previous
		if ($page == 1)
		{
			$this->prevpage = "<td id=\"class_previous_off\" class=\"class_pagination\">&nbsp;</td>";
		}
		else
		{
			$this->prevpage = "<td id=\"class_previous\" class=\"class_pagination\" onclick=\"javascript: window.location = '".$this->url.($page-1)."';\">&nbsp;</td>";
		}
		
		//next
		if ($page == $pages)
		{
			$this->nextpage = "<td id=\"class_next_off\" class=\"class_pagination\">&nbsp;</td>";
		}
		else
		{
			$this->nextpage = "<td id=\"class_next\" class=\"class_pagination\" onclick=\"javascript: window.location = '".$this->url.($page+1)."';\">&nbsp;</td>";
		}
		
		//last
		if ($page == $pages)
		{
			$this->lastpage = "<td id=\"class_right_off\" class=\"class_pagination\">&nbsp;</td>";
		}
		else
		{
			$this->lastpage = "<td id=\"class_right\" class=\"class_pagination\" onclick=\"javascript: window.location = '".$this->url.$pages."';\">&nbsp;</td>";
		}
		
		//pages
		$this->allpage = "<td id=\"class_pages\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		  <tr>";
		$start = $page-2;
		if ($start > $pages-4) {$start = $pages-4;}
		if ($start <= 0) {$start = 1;}
		
		for ($i=$start; $i<$start+5; $i++)
		{
			if ($i<=$pages)
			{
				if ($i==$page)
				{
					$this->allpage .= "<td class=\"class_page_off\">$i</td>";
				}
				else
				{
					$this->allpage .= "<td class=\"class_page\" onclick=\"javascript: window.location = '".$this->url.$i."';\">$i</td>";
				}
			}
		}
		if ($start <= $pages-5)
		{
			$this->allpage .= "<td class=\"class_page_dots\">...</td>";
			$this->allpage .= "<td class=\"class_page\" onclick=\"javascript: window.location = '".$this->url.$pages."';\">".$pages."</td>";
		}
		$this->allpage .= "</tr>
		</table></td>";
		
		//pagination
		$pagination = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"margin-bottom:".$this->margin_bottom."px; margin-top:".$this->margin_top."px; margin-left:".$this->margin_left."px; margin-right:".$this->margin_right."px;\">
		  <tr><td width=\"100%\" style=\"background:".$this->backcolor."; padding-left:".$this->padding_left."px; padding-right:".$this->padding_right."px; padding-top:".$this->padding_top."px; padding-bottom:".$this->padding_bottom."px;\" align=\"".$this->align."\" valign=\"".$this->valign."\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">".$this->firstpage.$this->prevpage.$this->allpage.$this->nextpage.$this->lastpage."</td><td id=\"total\">Ukupno ".$this->total.", prikazano od ".$this->shown."</table></td></tr>
		</table>";
		
		echo $pagination;
    }
	
	public function getTiny($prevlink = NULL, $nextlink = NULL)  
    {
		//previous
		if (empty($prevlink))
		{
			$this->prevpage = "<td id=\"class_previous_off\" class=\"class_pagination\">&nbsp;</td>";
		}
		else
		{
			$this->prevpage = "<td id=\"class_previous\" class=\"class_pagination\" onclick=\"javascript: window.location = '".$this->url.$prevlink."';\">&nbsp;</td>";
		}
		
		//next
		if (empty($nextlink))
		{
			$this->nextpage = "<td id=\"class_next_off\" class=\"class_pagination\">&nbsp;</td>";
		}
		else
		{
			$this->nextpage = "<td id=\"class_next\" class=\"class_pagination\" onclick=\"javascript: window.location = '".$this->url.$nextlink."';\">&nbsp;</td>";
		}

		//pagination
		$pagination = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"margin-bottom:".$this->margin_bottom."px; margin-top:".$this->margin_top."px; margin-left:".$this->margin_left."px; margin-right:".$this->margin_right."px;\">
		  <tr><td width=\"100%\" style=\"background:".$this->backcolor."; padding-left:".$this->padding_left."px; padding-right:".$this->padding_right."px; padding-top:".$this->padding_top."px; padding-bottom:".$this->padding_bottom."px;\" align=\"".$this->align."\" valign=\"".$this->valign."\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">".$this->prevpage.$this->nextpage."</table></td></tr>
		</table>";
		
		echo $pagination;
    }
	
	public function createIcons() 
	{
		if (!file_exists($this->icons))	
		{
			// create image
			$image = imagecreatetruecolor(291, 17);
			
			// allocate colors
			$bg   = imagecolorallocatealpha($image, $this->iconcolor_bg[0], $this->iconcolor_bg[1], $this->iconcolor_bg[2], $this->iconcolor_bg[3]);
			$normal = imagecolorallocatealpha($image, $this->iconcolor_normal[0], $this->iconcolor_normal[1], $this->iconcolor_normal[2], $this->iconcolor_normal[3]);
			$hover = imagecolorallocatealpha($image, $this->iconcolor_hover[0], $this->iconcolor_hover[1], $this->iconcolor_hover[2], $this->iconcolor_hover[3]);
			$disabled = imagecolorallocatealpha($image, $this->iconcolor_disabled[0], $this->iconcolor_disabled[1], $this->iconcolor_disabled[2], $this->iconcolor_disabled[3]);
			
			// fill the background
			imagealphablending($image, false);
			imagefill($image, 0, 0, $bg);
			imagesavealpha($image, true);
			
			// draw first icon
			//normal
			$offset = 0;
			imagefilledrectangle($image, 0+$offset, 0, 2+$offset, 16, $normal);
			$values = array(
				3+$offset, 8, 	// Point 1 (x, y)
				11+$offset, 0, 	// Point 2 (x, y)
				11+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $normal);
			//hover
			$offset = 25;
			imagefilledrectangle($image, 0+$offset, 0, 2+$offset, 16, $hover);
			$values = array(
				3+$offset, 8, 	// Point 1 (x, y)
				11+$offset, 0, 	// Point 2 (x, y)
				11+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $hover);
			//disabled
			$offset = 50;
			imagefilledrectangle($image, 0+$offset, 0, 2+$offset, 16, $disabled);
			$values = array(
				3+$offset, 8, 	// Point 1 (x, y)
				11+$offset, 0, 	// Point 2 (x, y)
				11+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $disabled);
			
			// draw second icon
			//normal
			$offset = 75;
			$values = array(
				0+$offset, 0, 	// Point 1 (x, y)
				8+$offset, 8, 	// Point 2 (x, y)
				0+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $normal);
			imagefilledrectangle($image, 9+$offset, 0, 11+$offset, 16, $normal);
			//hover
			$offset = 100;
			$values = array(
				0+$offset, 0, 	// Point 1 (x, y)
				8+$offset, 8, 	// Point 2 (x, y)
				0+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $hover);
			imagefilledrectangle($image, 9+$offset, 0, 11+$offset, 16, $hover);
			//disabled
			$offset = 125;
			$values = array(
				0+$offset, 0, 	// Point 1 (x, y)
				8+$offset, 8, 	// Point 2 (x, y)
				0+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $disabled);
			imagefilledrectangle($image, 9+$offset, 0, 11+$offset, 16, $disabled);
			
			// draw third icon
			//normal
			$offset = 150;
			$values = array(
				0+$offset, 8, 	// Point 1 (x, y)
				8+$offset, 0, 	// Point 2 (x, y)
				8+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $normal);
			imagefilledrectangle($image, 9+$offset, 5, 15+$offset, 11, $normal);
			//hover
			$offset = 175;
			$values = array(
				0+$offset, 8, 	// Point 1 (x, y)
				8+$offset, 0, 	// Point 2 (x, y)
				8+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $hover);
			imagefilledrectangle($image, 9+$offset, 5, 15+$offset, 11, $hover);
			//disabled
			$offset = 200;
			$values = array(
				0+$offset, 8, 	// Point 1 (x, y)
				8+$offset, 0, 	// Point 2 (x, y)
				8+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $disabled);
			imagefilledrectangle($image, 9+$offset, 5, 15+$offset, 11, $disabled);
			
			// draw fourth icon
			//normal
			$offset = 225;
			imagefilledrectangle($image, 0+$offset, 5, 6+$offset, 11, $normal);
			$values = array(
				7+$offset, 0, 	// Point 1 (x, y)
				15+$offset, 8, 	// Point 2 (x, y)
				7+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $normal);
			//hover
			$offset = 250;
			imagefilledrectangle($image, 0+$offset, 5, 6+$offset, 11, $hover);
			$values = array(
				7+$offset, 0, 	// Point 1 (x, y)
				15+$offset, 8, 	// Point 2 (x, y)
				7+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $hover);
			//disabled
			$offset = 275;
			imagefilledrectangle($image, 0+$offset, 5, 6+$offset, 11, $disabled);
			$values = array(
				7+$offset, 0, 	// Point 1 (x, y)
				15+$offset, 8, 	// Point 2 (x, y)
				7+$offset, 16	// Point 3 (x, y)
			);
			imagefilledpolygon($image, $values, 3, $disabled);
			
			
			// flush image
			//header('Content-type: image/png');
			imagepng($image, $this->icons);
			imagedestroy($image);	
		}
	}
}  
?>