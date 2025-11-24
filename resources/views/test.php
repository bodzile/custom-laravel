
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

<h1>Closures:</h1>
<?php 

function f1($value,$next){
    echo "<br>Ovo je prva funkcija, vrednost je " . $value;
    return $next($value);
}

function f2($value,$next){
    $value+=$value;
    echo "<br>Ovo je druga funkcija, vrednost je " . $value;
    return $next($value);
}

function f3($value){
    echo "<br>ovo je kraj, vrednost je: " . $value;
}
 
/*$increment=5;

$increment2=10;

$next=function($number) use ($increment){
    return $number+$increment;
};

$next=function($number) use($increment2,$next){
    return $next($number) + $increment2;
};

$res=$next(0);

echo "Rezultat: " . $res;*/


$middlewares=["Auth","Log"];


$next=function ($value){
    return f3($value);
};

$next=function ($value) use ($next){
    return f2($value,$next);
};

$next=function ($value) use ($next){
    return f1($value,$next);
};

$next(5);

?>


<?php require_once 'footer.php'; ?>

