<?php

namespace Concept\Controller;
use Concept\Model\AddingModel;
use Concept\Controller\NavbarAdminController;

class AddingController
{

	function __construct()
	{
		$this->generatePage();
	}
	
	function getCurrentUser()
	{
		return $_SERVER['REMOTE_USER'];
	}

	function generatePage()
	{
		$Model = new addingModel();
		// don't do anything with the model
		$loader = new Twig_Loader_Filesystem('../view/adminpage');
	        $twig = new Twig_Environment($loader);
		
		$navbar = new NavbarAdminController();
		$navbar = $navbar->generateNavbarHtml();
		
		$template = $twig->loadTemplate("adder.twig");
		return $template->render(array("navbar"=>$navbar,"add_marker"=>__DIR__ . '/../public/admin.php/Staff_makeMarker', "add_student"=>__DIR__ . '/../public/admin.php/Staff_makeStudent'));
	}

}


?>
