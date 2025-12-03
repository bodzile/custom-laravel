
<?php require_once 'header.php'; 
use Src\Sessions\Session;?>

<?php
if(isset($users))
    //print_r($users); die();
{
    foreach($users as $user){
?>    
    <div>
        <p>Id: <?php echo $user->id ?></p>
        <p>Name: <?php echo $user->name ?></p>
        <p>Difficulty: <?php echo $user->difficulty ?></p>
        <?php echo "---------------" ?>
    </div>
<?php
    }}
?>

<a href="<?php echo route("home") ?>">welcome page</a>

<?php 
    //$_SESSION["errors"]="aa";
    if(Session::has("errors"))
    {
        $errors=Session::get("errors");
        echo "<br>" . $errors[0] . "<br>";
    }

    if(Session::has("success"))
    {
        echo "<br>" . Session::get("success")["message"] . "<br>";
    }

?>

<form action="<?php echo route("admin.addUser") ?>" method="post">
    <input name="name" type="text"> <br>
    <input name="email" type="text"> <br>
    <input name="password" type="password"> <br>
    <button type="submit">Posalji</button>
</form>



<?php require_once 'footer.php'; ?>

