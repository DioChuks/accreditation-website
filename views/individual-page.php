<?php
if (isset($_GET['sch_lec_id'])) {
    $p_id = $_GET['sch_lec_id'];
    // Use prepared statement to retrieve school details
    $get_profile_sql = "SELECT * FROM tbl_profile WHERE profile_id = ?";
    // Prepare the statement
    $stmt = $conn->prepare($get_profile_sql);
    // Bind the parameter
    $stmt->bind_param("i", $p_id);
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();
    // Fetch the row
    $row = $result->fetch_assoc();
    // Close the statement
    $stmt->close();
    if (empty($row)) {
        echo "<script>alert('Profile not found');</script>";
        header("Location: ../index.php");
    }
    $profile_id = $row['profile_id'];
    $sch_id = $row['sch_id'];
    $cert_id = $row['cert_id'];
    $work_id = $row['work_id'];
    $p_name = $row['name_profile'];
    $faculty = $row['faculty'];
    $dept = $row['department'];
    $xp = $row['teaching_years'];
    $about_profile = $row['about_profile'];
    $x_about = $row['about_extra_profile'];
    $profile_image = $row['profile_image'];
    $quali = $row['qualification'];
}
?>
<style>
.back__to__school{
    position: absolute;
    left: 5%;
    top: 17%;
    display: inline-flex;
    align-items: flex-start;
    gap: 10px;
}
.back__to__school img{
    padding: 10px;
    border-radius: 31px;
    background: rgba(27, 115, 57, 0.20);
}
.individual__container{
    /* Frame 13 */
    /* Auto layout */
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    padding: 0px;
    gap: 51px;

    position: absolute;
    width: 1250px;
    height: auto;
    left: 70px;
    top: 200px;
}
.individual__container .individual__box{
    /* Frame 12 */
    /* Auto layout */
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 0px;
    gap: 11px;
    width: 550px;
    height: auto;
    /* Inside auto layout */
    flex: none;
    order: 0;
    flex-grow: 0;
}
.individual__box__title{
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-bottom: 1px solid #1B7339;
}
.individual__box__title h2{
    color: #1B7339;
    font-family: Poppins;
    font-size: 32px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}
.individual__box__title h2 span{
    color: #000;
    font-family: Poppins;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}
.individual__box__subtitle{
    display: inline-flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}
.individual__box__subtitle h4{
    color: #000;
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}
.individual__box__body{
    height: 600px;
}
.individual__box__body p{
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 27px;
    color: #000000;
    /* Inside auto layout */
    flex: none;
    order: 1;
    flex-grow: 0;
}
.individual__box__body p a{
    color: #1B7339;
    text-decoration: underline;
}
.individual__box__image{
    width: 612px;
    height: 485px;
    flex-shrink: 0;
    background: url(<?php echo $profile_image;?>), lightgray 50% / contain no-repeat;
}
.individual__box .individual__box__body__extra{
    margin-top: -50%;
    width: 1250px;
}
.individual__box__body__extra p{
    color: #000;
    font-family: Poppins;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}
.certificate__section{
    position: absolute;
    top: 800px;
    width: 92%;
    left: 4.5%;
    height: 400px;
    display: inline-flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}
.certificate__section__title{
    display: flex;
    padding: 10px 10px 10px 0px;
    align-items: flex-start;
    gap: 10px;
}
.certificate__section__title h2{
    color: #1B7339;
    font-family: Poppins;
    font-size: 32px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    padding-bottom: 10px;
    border-bottom: 1px solid #1B7339;
}
.certificate__section .certificate__item{
    display: flex;
    width: 100%;
    justify-content: space-between;
    gap: 130px;
    margin-top: -20px;
}
.certificate__item.styled{
    background-color: #D9D9D9;
}
.certificate__item__data.cert a{
    border-bottom: 1px solid #000;
}
.certificate__item .certificate__item__data h4,a{
    padding: 10px;
    color: #000;
    text-align: center;
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}
.certificate__item__data h5{
    margin-right: 20px;
}
.certificate__item__data h5,a:hover{
    cursor: pointer;
    transition: .2s ease-in-out;
    transform: translateY(-5px);
    font-weight: 700;
    color: #1B7339;
}
.works__section{
    position: relative;
    top: 1200px;
    width: 92%;
    left: 4.5%;
    height: 400px;
    display: inline-flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}
.works__section__title{
    display: flex;
    padding: 10px 10px 10px 0px;
    align-items: flex-start;
    gap: 10px;
}
.works__section__title h2{
    color: #1B7339;
    font-family: Poppins;
    font-size: 32px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    border-bottom: 1px solid #1B7339;
}
.works__achievement{
    margin-top: -3rem!important ;
}
.works__achievement .works__achievement__text h4{
    color: #000;
    font-family: Poppins;
    font-size: 20px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}
.works__achievement__text p{
    color: #000;
    font-family: Poppins;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}
.works__achievement__text .btn{
    display: flex;
    padding: 5px 20px;
    align-items: flex-start;
    gap: 10px;
    border-radius: 10px;
    background: #1B7339;
    color: #D9D9D9;
    font-family: Poppins;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    border: none;
}
.btn:hover{
    cursor: pointer!important;
    background: #40CE71;
    transition: .2s ease-in-out;
    transform: translateY(-5px);
    box-shadow: 1px 1px 2px 1px rgba(27, 115, 57, 0.20);
}
</style>
    <a href="?schools" target="_self" class="back__to__school">
        <img src="./Iconly/Light/Arrow - Left 3.svg" alt="arrow-left">
    </a>
    <section class="individual__container">
        <div class="individual__box">
            <div class="individual__box__title">
                <h2><?php echo $p_name;?> <span>Bsc, Phd</span></h2>
            </div>
            <div class="individual__box__subtitle">
                <h4><?php echo $quali;?></h4>
            </div>
            <div class="individual__box__body">
                <p>
                <?php echo $about_profile;?>
                </p>
            </div>
            <div class="individual__box__body__extra">
                <p class="individual__box__body__text2">
                <?php echo $x_about;?>
                </p>
            </div>
        </div>
        <div class="individual__box__image">
            <!-- profile picture here as background -->
        </div>
    </section>
    <?php
    $get_profile_sql = "SELECT * FROM tbl_certificate WHERE cert_id = ?";
    // Prepare the statement
    $stmt = $conn->prepare($get_profile_sql);
    // Bind the parameter
    $stmt->bind_param("i", $cert_id);
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();
    // Fetch the row
    $row2 = $result->fetch_assoc();
    // Close the statement
    $stmt->close();

    ?>
    <div class="certificate__section">
        <div class="certificate__section__title">
            <h2>Certifications</h2>
        </div>
        <div class="certificate__item styled">
            <div class="certificate__item__data"><h4><?php echo $row2['cert_title1']; ?></h4></div>
            <div class="certificate__item__data cert"><h5><a href="view_certificate.html">Click to view Certificate</a></h5></div>
        </div>
        <?php 
        if($row2['cert_title2'] != ''){
        ?>
        <div class="certificate__item">
            <div class="certificate__item__data"><h4><?php echo $row2['cert_title2']; ?></h4></div>
            <div class="certificate__item__data cert"><h5><a href="view_certificate.html">Click to view Certificate</a></h5></div>
        </div>
        <?php }?>
        <?php 
        if($row2['cert_title3'] != ''){
        ?>
        <div class="certificate__item styled">
            <div class="certificate__item__data"><h4><?php echo $row2['cert_title3']; ?></h4></div>
            <div class="certificate__item__data cert"><h5><a href="view_certificate.html">Click to view Certificate</a></h5></div>
        </div>
        <?php } ?>
    </div>
    <?php
    $get_profile_sql = "SELECT * FROM tbl_work WHERE work_id = ?";
    // Prepare the statement
    $stmt = $conn->prepare($get_profile_sql);
    // Bind the parameter
    $stmt->bind_param("i", $work_id);
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();
    // Fetch the row
    $row3 = $result->fetch_assoc();
    // Close the statement
    $stmt->close();

    ?>
    <div class="works__section">
        <div class="works__section__title">
            <h2>Works</h2>
        </div>
        <div class="works__achievement">
            <div class="works__achievement__text">
                <h4><?php echo $row3['work_title1']; ?></h4>
                <p><?php echo $row3['work_desc1']; ?></p>
                <button class="readmore btn">Read</button>
            </div>
            <?php 
        if($row['work_title2'] != ''){
        ?>
            <div class="works__achievement__text">
                <h4><?php echo $row3['work_title2']; ?></h4>
                <p><?php echo $row3['work_desc2']; ?></p>
                <button class="readmore btn">Read</button>
            </div>
            <?php }?>
        </div>
    </div>