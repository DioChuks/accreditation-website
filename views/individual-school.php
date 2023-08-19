<?php
if (isset($_GET['sch_id'])) {
    $sch_id = $_GET['sch_id'];
    // Use prepared statement to retrieve school details
    $get_school_sql = "SELECT sch_name, sch_desc, sch_website FROM tbl_schools WHERE sch_id = ?";
    // Prepare the statement
    $stmt = $conn->prepare($get_school_sql);
    // Bind the parameter
    $stmt->bind_param("i", $sch_id);
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();
    // Fetch the row
    $row = $result->fetch_assoc();
    // Close the statement
    $stmt->close();
    if (empty($row)) {
        echo "<script>alert('School not found');</script>";
        header("Location: ../index.php");
    }
    $school_name = $row['sch_name'];
    $sch_desc = $row['sch_desc'];
    $sch_website = $row['sch_website'];
}
?>

    <a href="?schools" target="_self" class="back__to__school">
        <img src="Iconly/Light/Arrow - Left 3.svg" alt="arrow-left">
    </a>
    <section class="school__container">
        <div class="school__box">
            <div class="school__box__title">
                <h2><?php echo $school_name;?></h2>
            </div>
            <div class="school__box__2">
                <div class="school__box__body">
                    <p><?php echo $sch_desc;?></p>
                    <p class="website">
                        <span>Website</span><br>
                        <span><a href="<?php echo $sch_website;?>" target="_blank" style="color: #1B7339;"><?php echo substr($sch_website, 8);?></a></span>
                    </p>
                </div>
                <div class="school__box__body__schools">
                    <span>No. of Faculties <br>14</span>
                    <span>No. of Department <br>60</span>
                    <span>No. of Staff <br>150</span>
                </div>
            </div>
        </div>
    </section>
    <style>
        #searchBtn:hover{
            cursor: pointer!important;
            transition: all .2s ease-in-out;
            transform: scale(.85);
        }
    </style>
    <section class="search__container__right">
        <div class="search__box__right">
            <div class="search__box__input__right">
                <span class="search__box__icon__right" id="searchBtn">
                    <img src="Iconly/Light/Search.svg" alt="search">
                </span>
                <input type="text" name="search" id="searchInstitution">
            </div>
            <div id="myModal2" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="work-details" id="searchResultField">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="institution__table__container">
        <div style="width:80%" class="institution__table__content">
            <div class="institution__table__head">
                <div class="table__head__title">Name</div>
                <div class="table__head__title">Department</div>
                <div class="table__head__title">Faculty</div>
                <div class="table__head__title">Current Qualification</div>
            </div>
            <?php
            $per_page=6;
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{   
                $page=1;
            }
            $start_from = ($page-1) * $per_page;
            $sch_id = $_GET['sch_id'];
            // Use prepared statement to retrieve school details
            $get_school_sql = "SELECT * FROM tbl_profile WHERE sch_id = ? ORDER by 1 DESC LIMIT ?,?";
            // Prepare the statement
            $stmt = $conn->prepare($get_school_sql);
            // Bind the parameter
            $stmt->bind_param("iii", $sch_id,$start_from,$per_page);
            // Execute the statement
            $stmt->execute();
            // Get the result
            $result = $stmt->get_result();
            ?>
            <div class="table__data__container">
                <?php
                // Fetch the row
                $x = 0;
            while($row = $result->fetch_assoc()){
                // Close the statement
                $stmt->close();
                if (empty($row)) {
                    echo "<script>alert('No Lecturers currently!');</script>";
                }
                $p_id = $row['profile_id'];
                $name = $row['name_profile'];
                $dept = $row['department'];
                $faculty=$row['faculty'];
                $quali =$row['qualification'];
                ?>
                <a href="?profile&sch_lec_id=<?php echo $p_id;?>">
                    <div class="table__data">
                        <div class="table__data__text institution"><?php echo $name;?></div>
                        <div class="table__data__text location"><?php echo $dept;?></div>
                        <div class="table__data__text typeof"><?php echo $faculty;?></div>
                        <div class="table__data__text staff"><?php echo $quali;?></div>
                    </div>
                </a>
                <?php
                $x++; 
                } 
                $total_records = mysqli_num_rows($result);
                $total_pages = ceil($total_records / $per_page);
                $conn->close();
                ?>
            </div>
        </div>
        <div class="pagination">
            <?php
            echo '<a href="?accredited_school&sch_id='.$sch_id.'&page=1" target="_self"><<</a> '.$page.' of '; 
            for($i=1; $i<=$total_pages; $i++){
                echo $total_pages.'<a href="?accredited_school&sch_id='.$sch_id.'&page="'.$i.'" target="_self">>></a>';
            }
            ?>
        </div>
    </section>
    <script>
        // for search
        const s = document.getElementById("searchBtn");
        const modalY = document.getElementById("myModal2");
        const t = modalY.querySelector(".work-details");
        var x = document.getElementsByClassName("close")[0];
        const q = document.getElementById("searchInstitution");
        var maxRows = 7;

        s.addEventListener("click", () => {
            modalY.style.display = "inline-flex";
            if(q.value == ''){
                return t.innerHTML = '<p style=color:red;text-align:center;font-family:Poppins>No result!</p>';
            }
            function queryData() {
                $.ajax({
                    url: "./php/search_lecturer.php",
                    type: "POST",
                    data: { search: q.value },
                    dataType: "json",
                    success: function (response) {
                        if (response.length > 0) {
                            t.innerHTML = '<div style=position:fixed;left:15%;z-index:2;color:rgba(0, 0, 0, 0.7);text-align:left;font-family:Poppins>Found '+ response.length +' results!</div>';
                            updateElement(response);
                            return;
                        }
                        if(response.length >= 0){
                            t.innerHTML = '<div style=position:fixed;left:15%;z-index:2;color:rgba(0, 0, 0, 0.7);text-align:left;font-family:Poppins>Found '+ response.length +' results!</div>';
                        }
                        else{
                            t.innerHTML = '<p style=position:fixed;left:15%;z-index:2;color:rgba(0, 0, 0, 0.7);text-align:center;font-family:Poppins>No result!</p>';
                            setTimeout( ()=>{
                                modalY.style.display = "none";
                                q.value = null;
                            },1500);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Error: " + error);
                    },
                });
            }
            function updateElement(queries) {
                var field = $("#searchResultField");
                var rows = field.find("a");
                // Remove excess rows if the table already has more than the maximum allowed rows
                if (rows.length >= maxRows) {
                    rows.slice(maxRows).remove();
                }
                $.each(queries, function (index, query) {
                var row = "<a id='queryData' href='?profile&sch_lec_id="+ query.profile_id +"'>" + query.profile_name +
                    "</a>";
                field.append(row);
                });
            }
            queryData();
        });
        x.onclick = function() {
            t.innerHTML = '';
            modalY.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modalY) {
                t.innerHTML = '';
                modalY.style.display = "none";
            }
        }
    </script>