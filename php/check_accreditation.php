<?php
    require_once ('connection.php');
    
    function validateData($data){
      $resultData = htmlspecialchars(stripslashes(trim($data)));
      return $resultData;
    }
    $profile_name = validateData($_POST['profile_name']);
    $faculty = validateData($_POST['faculty']);
    $dept = validateData($_POST['dept']);
    $about_profile = validateData($_POST['about_profile']);
    $extra_about = validateData($_POST['extra_about']);
    $teaching_years = validateData($_POST['experience']);
    $certificate_title1 = validateData($_POST['certificate_title1']);
    $certificate_title2 = isset($_POST['certificate_title2']) ? validateData($_POST['certificate_title2']) : null;
    $certificate_title3 = isset($_POST['certificate_title3']) ? validateData($_POST['certificate_title3']) : null;
    $work_title1 = validateData($_POST['work_title1']);
    $work_desc1 = validateData($_POST['work_desc1']);
    $work_link1 = validateData($_POST['work_link1']);
    $work_title2 = isset($_POST['work_title2']) ? validateData($_POST['work_title2']) : null;
    $work_desc2 = isset($_POST['work_desc2']) ? validateData($_POST['work_desc2']) : null;
    $work_link2 = isset($_POST['work_link2']) ? validateData($_POST['work_link2']) : null;

    $certificate_file1 = $_FILES['certificate_file1']['name'];
    $certificate_file2 = $_FILES['certificate_file2']['name'];
    $certificate_file3 = $_FILES['certificate_file3']['name'];

    $profile_image = $_FILES['profile_image']['name'];
    $temp_profile_img = $_FILES['profile_image']['tmp_name'];

    $temp_name1 = $_FILES['certificate_file1']['tmp_name'];
    $temp_name2 = $_FILES['certificate_file2']['tmp_name'];
    $temp_name3 = $_FILES['certificate_file3']['tmp_name'];

    move_uploaded_file($temp_name1,"../images/certificates/$certificate_file1");
    move_uploaded_file($temp_name2,"../images/certificates/$certificate_file2");
    move_uploaded_file($temp_name3,"../images/certificates/$certificate_file3");

    move_uploaded_file($temp_profile_img,"../images/profile-image/$profile_image");
    $profile_img_url = 'http://localhost/project/Praise/images/profile-image/'.$profile_image;
    
    $error_message = '';
    try {
            $insert_cert_sql = "INSERT INTO  tbl_certificate ( certificate_title1 ,  certificate_file1 ,  certificate_title2 ,  certificate_file2 ,  certificate_title3 ,  certificate_file3 ) 
            VALUES ('$certificate_title1','$certificate_file1','$certificate_title2','$certificate_file2','$certificate_title3','$certificate_file3')";
            $insert_work_sql = "INSERT INTO  tbl_work ( work_title1 ,  work_desc1 ,  work_link1 ,  work_title2 ,  work_desc2 ,  work_link2 ) 
            VALUES ('$work_title1','$work_desc1','$work_link1','$work_title2','$work_desc2','$work_link2'";
            $run_cert = mysqli_query($conn, $insert_cert_sql);
            $run_work = mysqli_query($conn, $insert_work_sql);
            $get_cert_id = "SELECT cert_id FROM tbl_certificate WHERE certificate_file1 = '$certificate_file1'";
            $get_work_id = "SELECT work_id FROM tbl_work WHERE work_title1 = '$work_title1'";
            $run_cert_id = mysqli_query($conn, $get_cert_id);
            $run_work_id = mysqli_query($conn, $run_work_id);
            $row_cert_id = mysqli_fetch_assoc($run_cert_id);
            $row_work_id = mysqli_fetch_assoc($run_work_id);
            $cert_id = $row_cert_id['cert_id'];
            $work_id = $row_work_id['work_id'];
            // insert into profile table
            $insert_profile_sql = "INSERT INTO tbl_profile ( sch_id ,  cert_id ,  work_id ,  name_profile ,  faculty ,  department ,  teaching_years ,  about_profile ,  about_extra_profile ,  profile_image ,  qualification ) 
            VALUES (1,'$cert_id','$work_id','$profile_name','$faculty','$dept','$teaching_years','$about_profile','$extra_about','$profile_img_url','Professor')";
            $run_insert_profile = mysqli_query($conn, $insert_profile_sql);
            if (!$run_insert_profile){
                echo '<script>alert("Something went wrong!")</script>';
            }
            $get_profile_sql = "SELECT profile_id FROM tbl_profile WHERE cert_id = '$cert_id'";
            $run_profile = mysqli_query($conn, $get_profile_sql);
            if($run_profile){
                $row_profile = mysqli_fetch_row($run_profile);
                $p_id = $row_profile['profile_id'];
                echo '<script>window.location.href=?profile&sch_lec_id='.$p_id.'</script>';
            }else{
                echo '<script>alert("There was an error!")</script>';
            }
        } catch (Exception $e) {
            echo "<span style='color:#ff214f'><i class='fas fa-times'></i>Message could not be sent. Mailer Error: {$mail->ErrorInfo} </span>";
        }
?>