<head>
	<title>DuckRead</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="styles.css">

	<style>
        .rating {
            float: left;
            width: 300px;
        }

        .rating span {
            float: right;
            position: relative;
			/*left: 0px;*/
        }

        .rating span input {
            position: absolute;
            top: 0px;
            left: 0px;
            opacity: 0; 
        }

        .rating span label {
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            color: #FFF;
            background: #ccc;
            font-size: 30px;
            margin-right: 2px;
            line-height: 30px;
            border-radius: 50%;
            -webkit-border-radius: 50%;
        }

        .rating span:hover~span label,
        .rating span:hover label,
        .rating span.checked label,
        .rating span.checked~span label {
            background: #F90;
            color: #FFF;
        }
    </style>
	
</head>