<?php
session_start();
$date=date("Y-m-d H:i:s");
$_SESSION["end_time"]=date("Y-m-d H:i:s", strtotime($date."+ $_SESSION[quiz_time] minutes"));
include "header.php";
include "connection.php";
?>

        <div class="row" style="margin: 0px; padding:0px; margin-bottom: 50px;">

            <div class="col-lg-6 col-lg-push-3" style="min-height: 500px; background-color: white;">
                <?php
                    $correct=0;
                    $wrong=0;
                    if(isset($_SESSION["answer"]))
                    {
                        for($i=1;$i<=sizeof($_SESSION["answer"]);$i++)
                        {
                            $answer="";
                            $res=mysqli_query($link, "select * from questions where category='$_SESSION[categories]' && question_no=$i");
                            while($row=mysqli_fetch_array($res))
                            {
                                $answer=$row["answer"];

                            }
                            if(isset($_SESSION["answer"][$i]))
                            {
                                if($answer==$_SESSION["answer"][$i])
                                {
                                    $correct=$correct+1;
                                }
                                else
                                {
                                    $wrong=$wrong+1;
                                }
                            }
                            else
                            {
                                $wrong=$wrong+1;
                            }
                        }
                    }
                    
                    $count=0;
                    $res=mysqli_query($link,"select * from questions where category='$_SESSION[categories]'");
                    $count=mysqli_num_rows($res);
                    $wrong=$count-$correct;
                    echo "<br>"; echo "<br>";
                    echo "<center>";
                    echo "Total Questions = ".$count;
                    echo "<br>";
                    echo "Correct Answer = ".$correct;
                    echo "<br>";
                    echo "Wrong Answer = ".$wrong;
                    echo "</center>";


                ?>
            </div>

        </div>
<?php
    if(isset($_SESSION["quiz_start"]))
    {
      $date=date("Y-m-d");
      mysqli_query($link, "insert into quiz_results(id,email,type,total_question,correct_answer,wrong_answer,time) values(NULL,'$_SESSION[email]','$_SESSION[categories]','$count','$correct','$wrong','$date')");
    }
    if (isset($_SESSION["type"]))
    {
        unset($_SESSION["quiz_start"]);
        ?>
        <script type="text/javascript">
            window.location.href=window.location.href;
        </script>
        <?php
    }

?>

<?php
include "footer.php";
?>