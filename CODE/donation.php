<?php
//Database
$servername="localhost";
$username="root";
$password="";
$dbname="savepaws";

//deatabase connection
$conn=new mysqli($servername,$username,$password,$dbname);

//Form submission
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $amount=$_POST["amount"];
    $custom_amount=$_POST["custom_amount"];
    $type=$_POST["type"];
    $reason=$_POST["reason"];
    
    if(!empty($_POST["amount"]) && empty($_POST["custom_amount"]) ){
        $amount = $_POST["amount"];
    }  
    else if(empty($_POST["amount"]) && !empty($_POST["custom_amount"])){
        $custom_amount=$_POST["custom_amount"];
        $amount = $custom_amount;
    }
    
    if(!is_numeric($amount) || $amount<=0){
    echo"<script>alert('Please enter a valid donation amount.');window.history.back();</script>";
    exit();
    } 
        //Insert into database
        $stmt=$conn->prepare("INSERT INTO donation(amount,type,reason) VALUES (?, ?, ?)");
        $stmt->bind_param("dss",$amount,$type,$reason);
        
        if($stmt->execute()){
            echo"<script>alert('Donation Successful!\\n\\nThank you for your donation of $amount taka\\nYour support makes a difference.');window.location.href='donation.html';</script>";
        }
        $stmt->close();
    }
$conn->close();
exit();
?>