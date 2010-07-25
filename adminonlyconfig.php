<div id="wrap" style="width:700px;">
 <?php echo "<h3>Multiple Author Ad management Administrative settings </h3>"; ?>
 
 <?php 

  if ($_POST['submit'] != "") {
    if($_POST['ratio'] <= 100) {
	 $ratior = $_POST['ratio'];
     update_usermeta(1, 'ratio' ,$ratior);
	}
	else {
	 echo "There is a problem with the input you entered for the ratio field! (Should be <= 100)";
	}
  }
 ?>
 
 <?php
    $ratio =  get_usermeta(1 ,'ratio');   
    if ($ratio == "") {
	 $ratio = 0;
	}
 ?>

 
 <form name="inputform" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
   <p>
     <label><b>Numerical Ad rotation ratio:  </b> </label><input type="text" name="ratio" value="<?php echo $ratio;?>" size="3" >%
	  <br />
      For example, a value of 50 into this field means that your advertisements will be displayed 50% of the time on other author's posts.
	  The default value is 0, meaning that the author's ads will be displayed 100% of the time.
   </p>
       
   <input type="submit" name="submit" value="Update Administrative settings" />
 </form>
 
 </div>
 
