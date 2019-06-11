<?php
/**
 * initialize the database
 * User: erxian
 * Date: 2019-06-10
 * Time: 22:53
 */
$m=11;
$n=7;
$current_m=10;
$current_n=6;
$conn=mysqli_connect("127.0.0.1","root","","mysql");
if(!$conn)
{
    die('connection_error'.mysqli_error());
}
if($current_m!=$m||$current_n!=$n)
{

    $sql="delete from ticket_status";
    $result=$conn->query($sql);
    if(!$result)
    {
        echo "error";
        $conn->close();
        return;
    }
    for($i=1;$i<=$m;$i++)
    {
        for($j=1;$j<=$n;$j++)
        {
            $sql="insert into ticket_status values (\'free\',$i,$j,NULL,NULL)";
            $result=$conn->query($sql);
            if(!$result)
            {
                echo "error";
                $conn->close();
                return;
            }
        }
    }
    $conn->close();
    return;
}
?>