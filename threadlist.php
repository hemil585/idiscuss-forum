<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iDiscuss Coding</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>
  <?php include("partials/_header.php")  ?>
  <?php include("partials/_dbconnect.php")  ?>
  <?php

  $id = $_GET['catid'];
  $sql = "SELECT * FROM `categories` WHERE category_id = $id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
  }

  ?>

  <?php
  $method = $_SERVER['REQUEST_METHOD'];
  $showAlert = false;
  if ($method == 'POST') {
    $th_title = $_POST['title'];
    $th_desc = $_POST['desc'];
    $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, 
    `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$id', '0', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    $showAlert = true;
    if($showAlert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success</strong> Your thread has been added! please wait till community to respond 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  }
  ?>

  <div class="container py-3">

    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Welcome to <?php echo $catname; ?> Forums</h1>
        <p class="col-md-8 fs-4"><?php echo $catdesc; ?> .</p>
        <hr>
        <ul>
          <p>Keep it friendly. <br>
            Be courteous and respectful. Appreciate that others may have an opinion different from yours.<br>
            Stay on topic. <br>
            Share your knowledge. <br>
            Refrain from demeaning, discriminatory, or harassing behaviour and speech.</p>
        </ul>
      </div>
    </div>

  </div>


  <div class="container">
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
      <div class="mb-3">
        <h2>Start a Discussion</h2>
        <label for="exampleInputEmail1" class="form-label"></label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="title" id="title" aria-describedby="emailHelp" placeholder="Problem Title">
      </div>
      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc" style="height: 100px"></textarea>
        <label for="floatingTextarea2">Elaborate your message</label>
      </div>
      <button type="submit" class="btn btn-success my-3">Submit</button>
    </form>
  </div>

  <div class="container" style="min-height:600px">
    <h1 class="py-2">Browse Questions</h1>
    <?php

    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $id = $row['thread_id'];
      $title = $row['thread_title'];
      $desc = $row['thread_desc'];

      echo '<div class="d-flex">
      <div class="flex-shrink-0">
        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAHoAegMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAAAwUEBgcBAv/EADkQAAICAAMGAwQHCAMAAAAAAAABAgMEBREGEiExUWETQXFCkaGxIjJScoHB0RQzNENTYuHwFSMk/8QAFgEBAQEAAAAAAAAAAAAAAAAAAAEC/8QAFxEBAQEBAAAAAAAAAAAAAAAAABEBEv/aAAwDAQACEQMRAD8A7iAAAAAAAAAAAAAAAAAAAAAAAAARX3QphvSfouoEkpKK1k0kvNmHdj4rhUt7u+CMK++d8tZ8vKPkiIsRkTxt8va3fREf7Rd/Vn7yMFgmji74/wAxv1MmrMHw8WK9YmABBd1WwtWtclJEhRQnKuW9B6PqWmExSuWkuE1zXUkVkgAgAAAAAPmclGLk3olzKfE3O+xyfL2V0Rm5lbpBVr2uL9CtLiAAKgDX9o9of+Ol+zYRRnitNZN8VX0/HsalZnGZ2Wb8sfiNe02l7lwA6aDTcj2ptjbGjNJqdcnor3wcfXt3NyAHsZSg1KL0a5HgKLrDXK6tS8+TXRkpVZfZuX7r5T+ZamdaAAQAABUY6W9iZduBjkmJ/iLfvMjNYgfFs1VVOyXKEXJ+iWp9kd9fi0W1/bhKPvWgRyu66eIunfa9Z2ScpPuz4PXFxbjJaNcGjwoevI6LstiZYrJKJWNudetbfXTl8NDnR0HZCp1ZFS5cPEnKenbXT8gLoAEHsXuyUl5PUvYvWKfUoS8p/dQ+6vkTVx9gAigAApsZHdxNnd6kJnZnXo42ac+DME1iAAfBavggjT9pNm7pYizG5fDxI2PesqXNPza6+hrUsLiYS3Z4e5S6ODN7xu1GW4WTjCcsRNc1StV73wK57ax1e7gZbve3j8gKnKdnMbjrou+qdGHX1pyWja7L/Ub9VXCmuFdUd2EIqMYrySKHC7X4C5qOIruo7tb0fhx+Be03VYiuNtFkLK5cpQeqYEgAAaa8OpewWkEuiKnBV+JiI9FxZcImrgACKAACO6tW1yg/MprIOubhJaNF6Y2LwyujqnpNcn1Lgprra6Kp22yUa4R3pN+SNAz7Prs0slXXrXhFyh5z7y/QtdusdOE68ujrH27e/wBlfN+41E0zoAClDLy3McTlt/i4aemv14P6s/VGICFdPynMqc0wkb6eD5Tg3xi+n+TMOd7MZg8Bmlak/wDpuarsXryf4P8AM6pg8I01ZbzXKLIuJcDR4Nesl9KXF9uxlAGVAAAAAAAAVWd5Dgc5q3cVUvES+hbHhOP4/kaFm2w+aYNuWESxlXlucJr1j+mp1I8a1LUjhV9F2GluYmmymXLdsg4v4keq6nd51QnHdnFSXSS1MZ5VlzerwGFb6+DH9C0jiUE5y3YJyk/KK1Zd5ZsnnGYSi1hZYet+3f8AQ+HN+46zThqKFpTTXWukIJfIkS0J0RreQbIYHKnG63/04pcVZOPCL/tXl68zZQCKAAAAAAAAAAAAAAAAAAAAAAAAAAD/2Q==" alt="...">
      </div>
      <div class="flex-grow-1 ms-3 py-2">
      <h3><a href = "thread.php?threadid=' . $id . '"> ' . $title . '</a></h3><br>
      ' . $desc . '      </div>
    </div>';
    }
    if ($noResult) {
      echo '<div class="p-3 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">No Threads found</h1>
        <hr>
        <ul>
          <p>Be the first person to ask the question!</p>
        </ul>
      </div>
    </div>';
    }
    ?>
  </div>

  <?php




  ?>

  <?php include("partials/_footer.php")  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

</html>