<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    echo "You do not have permission to access this page.";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users from the database
$sql_users = "SELECT id, ime, prezime, email, role_id, is_approved FROM users";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    echo "<h1>Manage Users</h1>";
    echo "<table border='1'>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>";

    while($row = $result_users->fetch_assoc()) {
        $role = $row['role_id'] == NULL ? 'None' : ($row['role_id'] == 1 ? 'Admin' : ($row['role_id'] == 2 ? 'Editor' : 'User'));
        $approved = $row['is_approved'] == 1 ? 'Approved' : 'Not Approved';
        
        echo "<tr>
                <td>{$row['ime']}</td>
                <td>{$row['prezime']}</td>
                <td>{$row['email']}</td>
                <td>{$role}</td>
                <td>{$approved}</td>
                <td>
                    <form action='admin.php' method='post'>
                        <select name='role_id'>
                            <option value='1' " . ($row['role_id'] == 1 ? 'selected' : '') . ">Admin</option>
                            <option value='2' " . ($row['role_id'] == 2 ? 'selected' : '') . ">Editor</option>
                            <option value='3' " . ($row['role_id'] == 3 ? 'selected' : '') . ">User</option>
                            <option value='' " . ($row['role_id'] == NULL ? 'selected' : '') . ">None</option>
                        </select>
                        <select name='is_approved'>
                            <option value='1' " . ($row['is_approved'] == 1 ? 'selected' : '') . ">Approved</option>
                            <option value='0' " . ($row['is_approved'] == 0 ? 'selected' : '') . ">Not Approved</option>
                        </select>
                        <button type='submit' name='update_user' value='{$row['id']}'>Update</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No users found.";
}

// Fetch news from the database
$sql_news = "SELECT id, title, is_approved FROM news";
$result_news = $conn->query($sql_news);

if ($result_news->num_rows > 0) {
    echo "<h1>Manage News</h1>";
    echo "<table border='1'>
            <tr>
                <th>Title</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>";

    while($row = $result_news->fetch_assoc()) {
        $approved = $row['is_approved'] == 1 ? 'Approved' : 'Not Approved';
        
        echo "<tr>
                <td>{$row['title']}</td>
                <td>{$approved}</td>
                <td>
                    <form action='admin.php' method='post'>
                        <select name='is_approved_news'>
                            <option value='1' " . ($row['is_approved'] == 1 ? 'selected' : '') . ">Approved</option>
                            <option value='0' " . ($row['is_approved'] == 0 ? 'selected' : '') . ">Not Approved</option>
                        </select>
                        <button type='submit' name='update_news' value='{$row['id']}'>Update</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No news found.";
}

// Update user
if (isset($_POST['update_user'])) {
    $user_id = $_POST['update_user'];
    $role_id = $_POST['role_id'] == '' ? NULL : $_POST['role_id']; 
    $is_approved = $_POST['is_approved'];

    $update_sql_user = "UPDATE users SET role_id = ?, is_approved = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql_user);
    $stmt->bind_param('iii', $role_id, $is_approved, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.');</script>";
        echo "<script>window.location.href = window.location.href;</script>";  
    } else {
        echo "<script>alert('Error updating user: " . $stmt->error . "');</script>";
    }
}

// Update news
if (isset($_POST['update_news'])) {
    $news_id = $_POST['update_news'];
    $is_approved_news = $_POST['is_approved_news'];

    $update_sql_news = "UPDATE news SET is_approved = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql_news);
    $stmt->bind_param('ii', $is_approved_news, $news_id);

    if ($stmt->execute()) {
        echo "<script>alert('News updated successfully.');</script>";
        echo "<script>window.location.href = window.location.href;</script>";  
    } else {
        echo "<script>alert('Error updating news: " . $stmt->error . "');</script>";
    }
}

$conn->close();
?>

<a href="index.php">Naslovnica</a>
