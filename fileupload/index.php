<?php
$conn = mysqli_connect("localhost", "root", "", "sample-db");
if(!$conn)
    echo "Failed to connect".mysqli_connect_error;

if(isset($_POST["submit"])){
    $imgfile = addslashes(file_get_contents($_FILES["imgfile"]["tmp_name"]));
    $sql = "INSERT INTO tbl_images(name) VALUES ('$imgfile')";
    if(mysqli_query($conn, $sql))
        echo "<script>alert('image uploade successfully');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image upload to data base</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <div class="container mt-3 py-4">
        <h3 class="text-center color-secondary">Image uploade to database</h3>
        <form action="" id="imgUpload" method="post" enctype="multipart/form-data">
            <label for="image">Upload File:</label>
            <input type="file" name="imgfile" id="imgf"><br><br>
            <input type="submit" id="imgUp" name="submit" value="Upload Fiel" class="btn btn-success">
        </form>
    </div>
    <div class="container">
        <h3 class="text-center">Uploaded Images</h3>
        <div id="img-display">
            <table class="table-bordered responsive">
                <tr>
                    <th>Image</th>
                </tr>
                <?php
                $sql = "SELECT * FROM tbl_images ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_array($result))
                    {
                        echo '<tr>
                            <td>
                                <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" height="200" width="200" class="img-thumnail"/>  
                            </td> 
                        </tr>';
                    }
                }
                else 
                    echo " no data found";
                
                ?>
            </table>
        </div>
    </div>
    
<script>
$(document).ready(function(){
    $("#imgUp").click(function(){
        var imgfname = $("#imgf").val();
        if(imgfname == ''){
            alert("plese Select Image");
            return false;
        }
        else {
            var extension = $("#imgf").val().split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['gif', 'jpg', 'jpeg','png']) == -1){
                alert("invalid image file");
                $("#imgf").val('');
                return false;
            }
        }
    });
    
});    
</script>
</body>
</html>