<?php

// INSERT INTO `notess` (`sn`, `title`, `description`, `tstamp`) VALUES (NULL, 'by books', 'Go to Market and buy the books', current_timestamp());
$insert=false;
$update=false;
$delete=false;
//connect to the database
$serverename="localhost";
$username="root";
$password="";
$database="notes";

//create a connection
$conn=mysqli_connect($serverename,$username,$password,$database);

//die if connection was not successful connection 
if(!$conn){
  die("sorry we failed to connected to the data base".mysqli_connect_error());

}
if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `notes` WHERE `sno`=$sno";
  $result=mysqli_query($conn,$sql);
};
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    //update the record
    $sno=$_POST['snoEdit'];
    $title=$_POST['titleEdit'];
    $description=$_POST['descriptionEdit'];
  
  //sql query inserted
$sql="UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno ";
$result=mysqli_query($conn, $sql);
if($result){
  $update=true;
}
  }
  
  else{
   $title=$_POST['title'];
  $description=$_POST['description'];
  
  //sql query inserted
$sql="INSERT INTO `notes` (`title`, `description`, `tstamp`) VALUES ('$title',  '$description' , current_timestamp())";
$result=mysqli_query($conn, $sql);

if($result){
    // echo "record have been created successfully<br>";
    $insert=true;
}else{
    echo "Error in recorded: ---". mysqli_error($conn);
  }
   }
  }

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> InotesCrud Application</title>
  <!-- bootstrap css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
 Edit Modal
</button>  -->

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModal">Edit This Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="/crud/index.php" method="post">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label"> Note Title</label>
              <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Note Description</label>
              <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="3"></textarea>
            </div>
           
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <div class="container-fluid ">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <!-- end navigation bar  -->
  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
   Your notes has been inserted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-primary alert-dismissible fade show' role='alert'>
    Your notes has been updated successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
     Your notes has been deleted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>

  <!-- form container -->
  <div class="container my-4">
    <h2>Add a Note to iNotes</h2>
    <form action="/crud/index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <!-- end form container -->

  <!-- data container -->
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">SN</th>
          <th scope="col">Title</th>

          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>

      </thead>
      <tbody>

        <?php
$sql="SELECT * FROM `notes`";
$result=mysqli_query($conn,$sql);
$sno=0;
while($row=mysqli_fetch_assoc($result)){
  $sno=$sno+1;
  echo " <tr>
 
  <th scope='row'>" .$sno."</th>
  <td> " .$row['title']."</td>
  <td> " .$row['description']."</td>
  <td><button type='button' class=' edit btn btn-dark' id= " .$row['sno']. ">Edit</button> 
  <button type='button' class='delete btn btn-dark' id=d".$row['sno'].">Delete</button></td>
</tr>";
  
}
?>

      </tbody>
    </table>

  </div>
  <hr>
  <!-- end of data container  -->

  <!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>

  <!-- jquery cdn link -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <!-- datatables cdn link css -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

  <!-- datatables cdn link javascript -->
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit",);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        // consol.log(e.target.id);

        $('#editModal').modal('toggle');

      });
    });
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit",);
        tr = e.target.parentNode.parentNode;
        sno = e.target.id.substr(1,);

        if (confirm("Are you sure you want to delete!")) {
          console.log('yes');
          window.location = `/crud/index.php?delete=${sno}`;
        }
        else {
          cosole.log('no');
        }

      });
    });
  </script>

</body>

</html>