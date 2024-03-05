<!DOCTYPE html>
<html>
    <head>
        <link href='../../css/tailwind.css' rel='stylesheet' type='text/css'>
        <link href='../../css/style.css' rel='stylesheet' type='text/css'>
        <link href='../../css/fontawesome/css/all.min.css' rel='stylesheet' type='text/css'>
        <script src='../../js/jquery/jquery.min.js'></script>
        <style>
            /* tr:nth-child(even){
                background: #ccc;
            }
            tr:nth-child(odd){
                background: white;
            } */
        </style>
    </head>
    <?php
        require_once '../../db.php';
        if(isset($_POST['teamName']) && isset($_POST['teamCategory'])){
            mysqli_query($conn, "INSERT INTO `response_teams`(`team_name`, `team_category`) VALUES ('$_POST[teamName]', '$_POST[teamCategory]')");
        }
    ?>
    <body style="font-family:Arial, Helvetica, sans-serif" class='overflow-hidden'>
    <nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
        <img src='../../img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
        <div class=''> 
            <h1 class="font-extrabold">Mzuzu City Council</h1>
            <h1 class='text-green-500 font-bold'>Fault/Complaints Management</h1>
        </div>
        <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
            <a href='../../' class='mx-'>Home</a>
            <a href='../../logout/' class='mx-4'>Logout</a>
            <a class='mx-4 add-team-btn'>Add Team</a>
        </div>
    </nav>

        <div class='inline-flex w-screen'>
            <div class='absolute w-64 p-4 shadow shadow-lg z-100 bg-white rounded top-10 left-1/2 hidden popup'>
            <button class='float-right underline close-btn'>Close</button>
                <div class='new-team'>
                    <h1 class='text-2xl border-b font-red-300'>Add New Team</h1>
                    <input type='text' class='w-full p-2 shadow-inner border my-2 team-name' placeholder='Team Name'/>
                    <input type='text' class='w-full p-2 shadow-inner border my-2 team-category' placeholder='Team Category'/>
                    <button class='p-2 bg-blue-500 my-2 rounded register-team prompt'>Register</button>
                </div>
                <div class='new-member'>
                    <h1 class='text-2xl border-b font-red-300'>Add New Team Member</h1>
                    <input type='text' class='w-full p-2 shadow-inner border my-2 member-fname' placeholder='Team Member First Name'/>
                    <input type='text' class='w-full p-2 shadow-inner border my-2 member-lname' placeholder='Team Member Last Name'/>
                    <input type='text' class='w-full p-2 shadow-inner border my-2 member-number' placeholder='Team Member Phone Number'/>
                    <input type='password' class='w-full p-2 shadow-inner border my-2 member-password' placeholder='Team Member Password'/>
                    <!-- <label class='text-gray-300'>Register as team member</label><input type='checkbox' class='is_leader'/> -->
                    <button class='p-2 bg-blue-500 my-2 rounded register-team prompt add-member'>Register</button>
                </div>
                <div class='list'></div>
            </div>
            <div class='bg-white shadow shadow-lg w-1/4 h-screen'>
                <a href="../"  class='w-full border-b block font-bold p-4 px-8'>Citizen Reports</a>
                <a href=""  class='w-full border-b block font-bold p-4 px-8 text-red-500 '>Manage Teams</a>
                <a href="../reports/"  class='w-full border-b block font-bold p-4 px-8'>Reports</a>
                <a href="../knowledge-base"  class='w-full border-b block font-bold p-4 px-8'>Manage Knowledge Base</a>
                <a href="../../leaflet/"  class='w-full border-b block font-bold p-4 px-8'>Reports Map View</a>
            </div>
            <div class='w-3/4 p-8 m-4'>
            <table class='border rounded m-auto w-full bg-white shadow shadow-lg rounded rounded-lg'>
                <tr class='border-b'>
                <td class=' p-4 text-center font-bold'>Team Name</td>
                    <td class=' p-4 text-center font-bold'>Team Category</td>
                    <td class='p-4 text-center text-green-500'></td>
                    <td class='p-4 text-center text-green-500'></td>
                </tr>
                    <?php
                        if($res = mysqli_query($conn, "SELECT * FROM `response_teams`")){
                            while($row = mysqli_fetch_array($res)){
                                echo "<tr class='border-b'>
                                    <td class=' p-4 text-center'>$row[team_name]</td>
                                    <td class=' p-4 text-center'>$row[team_category]</td>
                                    <td class='p-4 text-center text-green-500 underline'><a class='' onclick='popAddMember($row[ID])'>Add Member</a></td>
                                    <td class='p-4 text-center text-green-500 underline'> <a class='mx-8' onclick='popList($row[ID])'>View Members</a></td>
                                </tr>";
                            }
                        }
                    ?>
            </div>
        </div>
        <script>
            $('.add-team-btn').click(function(){
                $('.popup').fadeIn('slow')
                $('.new-member').hide()
                $('.list').hide()
                $('.new-team').fadeIn('slow')
            })
            $('.close-btn').click(function(){
                $('.popup').fadeOut('slow')
            })
            $('.register-team').click(function(){
                let teamName = $('.team-name').val()
                let teamCategory = $('.team-category').val()
                if(teamName && teamCategory){
                    $('.prompt').text('Wait...')
                    $.ajax({
                        url: 'index.php',
                        method: 'POST',
                        data: {
                            teamName: teamName,
                            teamCategory: teamCategory
                        },
                        success: function(res){
                            $('.prompt').text('Register');
                            $('.popup').hide();
                            document.location.reload(true)
                        },
                        error: function(err){
                            alert('HTTP ERROR')
                        }
                    })
                }
            })
            let popAddMember = function(teamId){
                $('.popup').fadeIn('slow')
                $('.new-team').hide()
                $('.new-member').fadeIn('slow')
                $('.member-fname').val("")
                $('.member-password').val("")
                $('.member-lname').val("")
                $('.member-number').val("")

                $('.list').hide()
                $('.add-member').click(function(){
                let memberlName = $('.member-lname').val()
                let memberfName = $('.member-fname').val()
                let memberPassword = $('.member-password').val()
                let phoneNumber = $('.member-number').val()
                console.log(phoneNumber, memberPassword, memberfName, memberlName)
                if(phoneNumber && memberPassword && memberfName && memberlName){
                    $('.prompt').text('Wait...')
                    console.log(0)
                    $.ajax({
                        url: 'api.php',
                        method: 'POST',
                        data: {
                            memberfName: memberfName,
                            memberlName: memberlName,
                            phoneNumber: phoneNumber,
                            memberPassword: memberPassword,
                            teamId: teamId
                        },
                        success: function(res){
                            alert(res)
                            $('.prompt').text('Register');
                            $('.popup').hide();
                        },
                        error: function(err){
                            alert('HTTP ERROR ')
                        }
                    })
                }
                else{
                    alert('some fields are empty')
                }
            })
            }

            let popList = function(ID){
                $.ajax({
                    url: 'api.php?list='+ID,
                    method: 'GET',
                    success: function(res){
                        $('.popup').fadeIn('slow')
                        $('.new-team').hide()
                        $('.new-member').hide()
                        $('.list').fadeIn('slow')
                        $('.list').html(res)
                    },
                    error: function(err){
                        alert('HTTP ERROR ')
                    }
                })
            }
            let dropMember =  function(id){
                if(confirm('Delete this team member?')){
                    $.ajax({
                        url: 'api.php?drop='+id,
                        method: 'GET',
                        success: function(res){
                            alert(res)
                            $('.popup').hide()
                        }, 
                        error: function(err){
                            alert('HTTP ERROR')
                        }
                    })
                }
            }
        </script>
