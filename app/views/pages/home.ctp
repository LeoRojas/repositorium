<?php $this->viewVars['title_for_layout'] = "Repositorio de Problemas y Soluciones"; ?>
<table width = "100%" height = "90%" align = "center" bgcolor = "white">   
  <tr>
	<td align = "center">
	  <br/><br/><br/><br/><br/> 
	  <?php
	  echo $this->Form->create('Tag', array('action' => 'search'));
	  ?>
	  <div style="width:500px;">
      		<?php echo $this->Form->input('search', array('label' => false));?>	  
	  </div>
	  <br />
	<?php echo $this->Form->end('Search');
	  ?> 
	  
	</td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
	add_textboxlist("#TagSearch");
</script>

