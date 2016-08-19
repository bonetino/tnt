<?php
//CLASS show messages
class message  
{
	public function __construct($mess) 
	{
		if (!empty($mess))
		{
			$_SESSION['message'] = $mess;
			session_write_close();
		}
		//echo $mess." - ".$_SESSION['message'];
    }
	
	public function showMessage()  
    {  
		$mess = $_SESSION['message'];
		$this->unsetMessage();
        return '<script>
		$(function() {
			$(\'<div></div>\').appendTo(\'body\')
			  .html(\'<div><br /><strong>'.$mess.'</strong></div>\')
			  .dialog({
				  modal: true, title: \'Poruka sustava\', zIndex: 10000, autoOpen: true,
				  width: 500, resizable: false,
				  buttons: {
					  "OK": function () {
						  $(this).dialog("close");
					  },
				  },
				  close: function (event, ui) {
					  $(this).remove();
				  }
			});
		});</script>';
    } 
	
	public function unsetMessage()
	{
		unset($_SESSION['message']);
		session_write_close();	
	}
}  
?>