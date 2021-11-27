<!DOCTYPE html>
<html>
<head> 
	<title>Bank Receipt</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap"
	rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<style type="text/css">
	body {
		/*font-size: 14px !important;*/
		font-family: 'Source Sans Pro', 'Regular' !important;
		background-color: #fff !important;
		color: #3D3D3D!important;
		width: 100%;
		height: 100%;
		margin: 0px;
		padding: 0px;
		/*overflow-x: hidden; */
	}
	.img{
		width:120px;
	}
	.form-group{
		display: flex !important
	}
	.form-control{
		height:34px !important;
	}
	.font{
		font-size:1.20rem !important;
	}
</style>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="https://psra.gkp.pk/schoolReg/assets/logo.png" class="img-responsive img" />
            </div>  
            <div class="col-md-8 mt-5">
                <h4 class="font"><b>Note Sheet File</b>: NCS Public school Peshawar Ring road near sarahad universtiy</h4> 
            </div>                  
        </div><hr>

        <div class="row"> 
            <div class="col-md-12">
                <h5>Subject :</h5> 
            </div> 
            <div class="col-md-12">
                <h6><?php echo $subject;?></h6> 
            </div>

            <div class="col-md-12">
                <h5>Remarks :</h5> 
            </div>
            <ul>
                <?php foreach($data as $row):?>
                <li>
                    <div class="col-md-12">
                <hp><?php echo $row['para_text'];?></hp> 
                </div>  
                 
                <div class="col-md-12">
                   <p><strong>remarks By: </strong> <span><?php echo $row['userTitle'];?></span>   <strong>Date: </strong> <?php echo $row['para_created_at'];?></p>
                </div>  
                </li>
                <?php endforeach;?>
            </ul>   
                   
                               
        </div>
        
    </div>
    <script type="text/javascript">
<!--
window.print();
//-->
</script>
</body>

</html>