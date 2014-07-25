<?php
$cn = mysql_connect("localhost","root","alumno");
mysql_select_db("smeagol");


// función que genera l array navigation
// parent_id= id a partir de donde se extraerá el arbol
// path = string con ruta de los índices del array multidimensional hasta llegar al page a insertar
// exclude = indice de menú a excluir
// menu_tree_array = array Navigation
// include_itself = boleano que indica si se incluye o no el id buscado en menu_tree_array

function get_menu_tree($parent_id = '0', $path="", $exclude = '', $menu_tree_array = '', $include_itself = false) {
    global $cn;
    
    if (!is_array($menu_tree_array)) $menu_tree_array = array();
    if ( (sizeof($menu_tree_array) < 1) && ($exclude != '0') ) $menu_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);

    if ($include_itself) {
	  $query1= "select label from menu where id = '" . (int)$parent_id . "'";
	  //echo($query1."\n");
      $menu_query = mysql_query($query1,$cn);
      $menu = mysql_fetch_assoc($menu_query);
      $menu_tree_array[] = array('id' => $parent_id, 'text' => $menu['label']);
    }

	$rquery = "select id, name, label, parent_id, url, node_id from menu where parent_id=".(int)$parent_id." order by order_id";
	
    $menus_query = mysql_query($rquery,$cn);
    while ($menus = mysql_fetch_assoc($menus_query)) {
        $route="home";
		$controller="";
		$action="";
		
      	if ($exclude != $menus['id']) {
          if(is_null($menus['node_id'])){
			  if($menus['url'] != '/'){
			     $m = explode("/",$menus["url"]);
				 $route = $m[0];
				 if(!empty($m[1])){
					$controller = $m[1];
				 }else{
				    $controller = "index";
				 }	
				 if(!empty($m2)){
				    $action = $m[2];  
				 }else{
				    $action = "index";
				 }
			  }			  
		  }else{	 
		      $route = "node";
		  }
		  
		  
	      $page = array('id' => $menus['id'], 
	                                 'label' => $menus['label'], 
			                         'route' => $route);
			if(!empty($controller)){
				$page['controller'] = $controller;
				if(!empty($action)){
					$page['action'] = $action;
				}
			}else{
				$qlink = "select url from node where id=".$menus["node_id"];
				$q = mysql_query($qlink);
				if($q){
					$rs = mysql_fetch_assoc($q);
				    $page['params'] = array ('id'=>$menus['id'],'link' => $rs['url']); 
				}
		    }

			 
			if(empty($path)){
				$menu_tree_array[] = $page;
				end($menu_tree_array);
				$last_key = key($menu_tree_array).":";
    		}else{
			    $pt = explode(":",$path);
				$temp = & $menu_tree_array;
				foreach($pt as $p){
					//print_r($temp);
					if(!empty($p)){
						$temp = &$temp[$p];
					}
				}
				//echo $path."\n";	
				
				$temp["pages"]["menu".$menus['id']] = $page;
				end($temp["pages"]);
				$last_key = "pages:".key($temp["pages"]).":";
				unset($temp);
     		}			
		}		
	    $menu_tree_array = get_menu_tree($menus['id'], $path.$last_key, $exclude, $menu_tree_array);
    }

    return $menu_tree_array;
}  