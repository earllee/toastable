                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ‘Main Title ## The title of the main area
on the homepage.’,
			* Dont forget the comma at the end of each line ! */
	'main_title' => 'Title ## (The huge title header of your website/product/services)<br />',
	'main_desc' => 'Description ## (A short description about your website/product/services)',
	'feedburner_url' => 'Feedburner ID ## (E.g: The ID for <em>feeds2.feedburner.com/netizensmedia</em> will be <strong>netizensmedia</strong>)',
	'logo_url' => 'Logo ## (URL of your logo. Ideal size: 240px wide x 235px high)',


	'debug' => 'debug', 	/* this is a fake entry that will activate the "Programmer's Corner"
			 * showing you vars and values while you build your theme. Remove it
			 * when your theme is ready for shipping */
	),
	__FILE__	 /* Parent. DO NOT MODIFY THIS LINE !
			  * This is used to check which file (and thus theme) is calling
			  * the function (useful when another theme with a Theme Toolkit
			  * was installed before */
);
	
/************************************************************************************
 * THEME AUTHOR : Congratulations ! The hard work is all done now :)
 *
 * From now on, you can create functions for your theme that will use the array
 * of variables $mytheme->option. For example there will be now a variable
 * $mytheme->option['your_age'] with value as set by theme end-user in the admin menu.
 ************************************************************************************/

/***************************************
 * Additionnal Features and Functions
 *
 * Create your own functions using the array
 * of user defined variables $mytheme->option.
 *
 **************************************/

function creditcard() {
	global $mytheme;
	print "My Credit Card Number is : ";
	print $mytheme->option['creditcard'];
}


/***************************************
*To bypass WordPress theme requirement ;)
if ( function_exists('register_sidebar') )
    register_sidebar();
 **************************************/
?>