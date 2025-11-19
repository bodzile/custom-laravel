
<?php require_once 'header.php'; 
use Src\Sessions\Session;?>

<?php
if(isset($users))
{
?>    
    <div>
        <p>Id: <?php echo $users["id"] ?></p>
        <p>Name: <?php echo $users["name"] ?></p>
    </div>
<?php
}
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
    <input name="email" type="text"> <br>
    <input name="password" type="password"> <br>
    <button type="submit">Posalji</button>
</form>


<?php require_once 'footer.php'; ?>

