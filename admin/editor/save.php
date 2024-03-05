<?php
    require_once '../../db.php';
    if(isset($_POST['articleTitle']) && isset($_POST['content'])){
        if(mysqli_query($conn, "INSERT INTO `knowledge_articles`(`articleTitle`, `articleBody`) VALUES ('$_POST[articleTitle]', '$_POST[content]')")){
            echo "Article Saved Successfully.";
        }
        else{
            echo "Saving Failed.";
        }
    }
    else{
        echo "Saving Failed.";
    }
?>