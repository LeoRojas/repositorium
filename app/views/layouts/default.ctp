﻿<?php
/**
 * default.ctp
 * 
 * layout principal del sitio
 * 
 * @package   views
 * @author    Mauricio Quezada <mquezada@dcc.uchile.cl>
 * @copyright Copyright (c) 2011 
 */
?>
<!DOCTYPE html>
<html>
<head>
  <?php echo $this->Html->charset(); ?>
  <title><?php echo $title_for_layout; ?></title>
  <?php 
	  echo $this->Html->meta('icon');
      //echo $this->Html->css('reset');
      //echo $this->Html->css('style');
      //echo $this->Html->css('tabla');
      echo $this->Html->css('reset-fonts-grids.css');      
      //Include JQuery & JQueryUI
      echo $this->Html->script('jquery.min');
      echo $this->Html->script('jquery-ui-1.8.13.custom.min');
      echo $this->Html->css('anchors');
      echo $this->Html->css('jqueryui');
	  echo $this->Html->css('style2');
	  
      echo $scripts_for_layout;
      //Include TextBoxList
      echo $this->Html->script('GrowingInput');
      echo $this->Html->script('TextboxList');
      echo $this->Html->css('TextboxList');
      echo $this->Html->script('TextboxList.Autocomplete');
 ?>
  <script type="text/javascript" language="javascript">
  	$(document).ready(function() {
  		$('.textboxlist-autocomplete-results').hide();
  	});
  	
	function add_textboxlist(selector){ 
		$("" + selector).textboxlist({
			unique : true,
			bitsOptions : {
				editable : {
					addOnBlur : true, 
					addKeys : [188]					
					}},
			plugins: {
				autocomplete: {
					minLength: 3,
					queryRemote: true,
					remote: {
						url: '<?php echo $this->Html->url(array('controller' => 'tags', 'action' => 'autocomplete')); ?>'					
					}
			}}});
	}

//	function add_close_button(){
//		var flash=$("#flashMessage");
//		//Create the Div
//		var div_close = $("<div></div>");
//		div_close.css({'float' : 'right', 'text-align' : 'right'});
//		//Create the A
//		var a_close = $("<a></a>");
//		a_close.css({'color' : '#333', 'cursor' : 'pointer'});
//		a_close.html("X");
//		a_close.click(close_flashMessage);
//		//Append A to Div
//		div_close.append(a_close);
//		//Append the Div to the flashMessage Div
//		flash.append(div_close);
//	}
//	
//	function close_flashMessage(){
//		$("#flashMessage").hide('slow');
//	}
//	
//	$(function(){
//		add_close_button();
//	});
	
	//Improve the flashMessage
	$("#flashMessage").addClass("ui-state-highlight ui-corner-all flash-style");

	//Convert submit buttons to JQueryUI buttons
	$(function () {
		$(":submit").button();
		//add classes to textboxes
		$(":text, :password, textarea, select").addClass("text ui-widget-content ui-corner-all");
		//$(".textboxlist").addClass("");
		$("#flashMessage").addClass("ui-state-highlight ui-corner-all flash-style");	
});
  </script>
</head>
<body>
    <div id="doc3">
        <div id="hd">
            <div class="header">
                <div class="logo">
                    <?php echo $this->Html->link($this->Html->image('logo2.png'), '/', array('escape'=>false)); ?>
                </div>
                <div class="box userbox">
                    <ul class="nav topmenu">
                        <?php if(!$this->Session->check('Usuario.id')) { ?>
                        <li><?php echo $this->Html->link('Sign in', '/registro', array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Log in', '/iniciar_sesion', array('escape' => false)); ?></li>
                        <?php } else {
                            $nombre = $this->Session->read('Usuario.nombre');
		                    $puntos = $this->Session->read('Usuario.puntos');
                        ?>
                        <li>Hey, <?php echo $nombre.'! ('.$puntos.' points)';?></li>
                        <li><?php echo $this->Html->link('Edit profile', '/usuarios'); ?></li>
                        <li><?php echo $this->Html->link('Logout', '/iniciar_sesion/logout'); ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="box optionsbox">
                    <div class="nav form">
                    	<?php 
                    		echo $this->Form->create(null, array('url' => '/tags/search'));
                    	?>
                    		<div class="input text search"><input name="data[Tag][search]" type="text"></div>
                    	<?php
                    		echo $this->Form->end();
                    	?> <!--
                        <form id="TagSearchForm" method="post" action="tags/search" accept-charset="utf-8">
                            <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>                            
                        </form>
                        -->
                    </div>
                    <ul class="nav subtopmenu">
                        <?php if($this->Session->check('Usuario.esAdmin') or $this->Session->check('Usuario.esExperto')): ?>
	                    <li><?php echo $this->Html->link('Manage', '/admin_documentos');?></li>
                    	<?php endif; ?>                        
                        <li><?php echo $this->Html->link('Add document', array('controller' => 'subir_documento', 'action' => 'index'));?></li>
                        <?php if($this->Session->check('Usuario.id') and $this->Session->read('Usuario.id') > 1): ?>
                        <li><?php echo $this->Html->link('Earn points', array('controller' => 'desafios', 'action' => 'earn')); ?></li>
                        <?php endif; ?>
                    </ul>                    
                </div>
            </div>
        </div>

        <div id="bd">   
            <div class="content">
	          <!-- real content -->
	          <div id="breadcrumb"><?php echo $this->Html->getCrumbs(' > ','Home'); ?></div>
			  <?php echo $this->Session->flash(); ?>
	          <?php echo $content_for_layout; ?>
	          <?php if(Configure::read('debug') > 0) { ?>
		          <!-- debug -->
		          <h1><a onclick="javascript:$('#debugbox').toggle()" style="cursor: pointer">Toggle Debug</a></h1>
	          	  <h1><a onclick="javascript:$('#sqlbox').toggle()" style="cursor: pointer">Toggle SQL</a></h1>
		          <div class="debug" id="sqlbox" style="display:none">
			        <?php echo $this->element('sql_dump'); ?>
		          </div>
	          <?php
         		   echo '<div class="debug" id="debugbox" style="display:none">';
		           $vars = $this->getVars();
		           foreach($vars as $var) { 
	                 pr($var); pr($$var);
	               }
		           echo '</div>';
		         }
	           ?>
            </div>
    	</div>

        <div id="ft">
            <div class="footer"></div>
        </div>
    </div>
</body>
</html>
