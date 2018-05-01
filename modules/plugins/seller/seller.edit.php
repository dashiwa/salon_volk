<?php
        include('seller.class.php');

        $seller = new seller();

		if ( count($seller->seller) > 0)
		{
		 //echo '<';
		foreach ($seller->seller as $value)
		{
		  print_r($value);
		}
		
		}
?>