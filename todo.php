<?php
$db = mysqli_connect('localhost', 'root', '', 'todo');
if(!$db){
    die('cannot connect to database!!');
}


if($_POST){
  $sql = 'INSERT INTO todo_list_table(todo) VALUE (?)';
  $stmt = $db->prepare($sql);
  $stmt->bind_param('s', $_POST['todo']);
 if ($stmt->execute()){
     header('location:todo.php');
 }
}


if(isset($_GET['done']) && $_GET['done'] != 1 ){
    $sql = 'UPDATE  todolist_table
      SET done = 1';
      
    
    $stmt = $db->prepare($sql);
    if ($stmt->execute()){
        header('location:todo.php');
    }

}



if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['todo'])){
    $sql = 'DELETE FROM todolist_table WHERE todo = ?';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $_GET['todo']);
    $stmt->execute();
}



 ?>
 <!DOCTYPE html>
<html>
 
 <head>

  <title>
    Task
  </title>
 <link rel="stylesheet" href="./css.style.css">
 </head>

<body>

 <h1> My To-do's List </h1>
 <form method="POST" action="todo.php" enctype="multipart/form-data">
 <input class="text" type="text" placeholder="New Task ..">
 <button>Add to List</button>
 </form>

 <?php
                    $sql = 'SELECT * from todolist_table';
                    $result = $db->query($sql);
                    while (($row = $result->fetch_assoc())):
                    ?>
                <ul id="list">
                    <li > 
                        <?php if(!$row['done']): ?>
                        <a href="todo.php?done=<?= $row['done'] ?> "  class="done"  > 
                      | &nbsp Mark as Done </a>
                        
                        <?php endif; ?>
                        <a href="todo.php?action=delete&todo=<?= $row['todo'] ?>"  class="del" > &nbsp Delete</a>                          
                    </li>
               
                 <?php endwhile ?>

</body>



</html>
