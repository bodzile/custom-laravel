
<?php require_once 'header.php'; 
use Src\Sessions\Session;
?>


<h1>Welcome </h1>
<p>aa</p>
<a href="<?php echo route("admin.testPage")?>">Klik </a>


<?php
if(isset($name))
{
?>    
    <h3><?php echo $name ?></h3>
<?php
}
?>


<?php require_once 'footer.php'; ?>

