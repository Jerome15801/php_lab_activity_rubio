<?php 
include('dbcon_php');

$message = "";
$messageType = "success";

if (isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if(!empty($name) && ! empty ($email)){
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        if ($stmt->execute()){
            header("Location:index.php?status=added");
            exit();
        } else {
            $message = "Error adding user!";
            $messageType ="danger";
        }
        $stmt->close();
    } else {
        $message = "Please fill in all fields!";
        $messageType = "warning";
    }
}

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'added') {
        $message = "User added successfully!";
    } else if($_GET['status'] === 'updated') {
        $message= "User updated successfully!";
    } else if ($_GET['status'] === 'deleted') {
        $message = "User deleted successfuly!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset =" UTF-8">
    <meta name="viewport" content="width-device=width, initial-scale=1.0">
    <title>PHP MYSQL CRUD</title>

    <link href= "https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel ="stylesheet">
</head>

<body class="bg-light">
    <nav class ="navbar navbar-dark bg-primary shadow-sm">
        <div class ="container">
            <a class="navbar-brand fw-bold" href="index.php">PHP Mysql CRUD</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    < class ="card-header bg-primary text-white">
                    <h5 class=mb-0>Add New User</h5>                
                </div>
                <div class= "card-body"></div>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> alert-dismissable fade show">
                            <?php echo htmlspecialchars($message); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif;?>

                        <form method="POST" action="index.php">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email address" required>
                            </div>
                            <button type="submit" name="add_user" class="btn btn-primary w-100">Add user</button>
                        </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">User list</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-stripped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                    </thead>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>