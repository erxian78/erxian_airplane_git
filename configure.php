<?php
$m=11;
$n=7;
$current_m=0;
$current_n=0;
$conn=new mysqli("localhost","s261423","subgreds","s261423");
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
    for($i=1;$i<$m;$i++)
    {
        for($j=1;$j<$n;$j++)
        {
            $sql="insert into ticket_status values ('free',$i,$j,NULL,NULL)";
            $result=$conn->query($sql);
            if(!$result)
            {
                echo "error2";
                $conn->close();
                return;
            }
        }
    }
    echo "success";
    $conn->close();
}
?>