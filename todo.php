<?php
include 'db.php';
// Proses insert data
if (isset($_POST['add'])) {
    $q_insert = "INSERT INTO task (task_lable, task_status) VALUE (
        '" . $_POST['task'] . "',
        'open'
    )";
    $run_q_insert = mysqli_query($connect, $q_insert);
    if ($run_q_insert) {
        header('Refresh:0; url=todo.php');
    }
}

// Proses show data
$q_select = "SELECT * FROM task ORDER BY task_id DESC";
$run_q_select = mysqli_query($connect, $q_select);

// Proses delete data
if(isset($_GET['delete'])) {
    $q_delete = "DELETE FROM task WHERE task_id = '".$_GET['delete']."'";
    $run_q_delete = mysqli_query($connect, $q_delete);
    header('Refresh:0; url=todo.php');
}

// Proses update data (close or open)
if(isset($_GET['done'])) {
    $status = 'close';

    if($_GET['task_status'] == 'open') {
        $status = 'close';
    }else {
        $status = 'open';
    }

    $q_update = "UPDATE task SET task_status = '".$status."' WHERE task_id = '".$_GET['done']."'";
    $run_q_update = mysqli_query($connect, $q_update);
    header('Refresh:0; url=todo.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="berstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://lottie.host/055aac10-c62e-4763-9f74-fb8a0c3d2351/D4vOM9p5ex.json' rel='stylesheet'>
    

</head>
<body>
    <section class="awal">
        <img class="gambar" src="images/Group 2.png" alt="photo">    
    </section>


    <div class="semua">

        <div class="container">
            <!-- ini untuk header -->
            <div class="header">
                <div class="title">
                    <i class='bx bx-sun bx-spin' ></i>
                    <span>Let’s make our to do list!!</span>
                </div>
                <div class="description">
                    <?=date("l, d M Y")?>
                </div>
                <div class="card">
                    <form action="" method="post">
                        <input name="task" type="text" class="input-control" placeholder="Add Task" >
                        <div class="text-right">
                            <button type="submit" name="add">Add</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="content">
                    <!-- ini untuk tugas -->
                    <?php
            if(mysqli_num_rows($run_q_select) > 0){
                while($r = mysqli_fetch_array($run_q_select)){
                    

            ?>
            <div class="card">
                <div class="task-item <?=$r['task_status'] == 'close' ? 'done':''?> ">
                    <div>
                        <input type="checkbox" onclick="window.location.href = '?done=<?=$r['task_id']?>&status=<?= $r['task_status']?>'"<?= $r['task_status']== 'close'?'checked':''?>>
                        <span> <?=$r['task_lable']; ?> </span>
                    </div>
                    <div>
                        <a href="edit.php?id=<?=$r['task_id']?>" class="edit-task"><i class='bx bx-edit bx-tada'title="edit" ></i></a>
                        <a href="?delete= <?=$r['task_id']?>" class="delete-task" title="remove"onclick="return confirm('Are you sure?')"><i class='bx bx-trash bx-tada' ></i></a>
                    </div>
                </div>
            </div>
        <?php }}else { ?>
            <div>Belom ada Data</div>
        <?php }?>
        
        
    </div>    

</body>
</html>