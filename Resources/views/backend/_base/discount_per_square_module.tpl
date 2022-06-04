<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
    <style>
        .dps-info{
                border: 1px solid #c4c4c4;
                max-width: 27%;
                margin: 2%;
                padding: 2rem;
                color: #5c6f7c;
                text-align: center;
                margin-left: 4%;
        }
        .btn-container{
                max-width: 39%;
                margin: 2% auto;
                display: flex;
                justify-content: space-evenly;
               
        }
        
        .generate, .delete{
            background-image:url(https://dev.krono-shop.com/media/vector/ac/50/09/backgrnd.svg) !important;
            text-shadow: 0 1px 1px #555 !important;
             
        }
       
        .generate:hover,
        .delete:hover {
            
            color: #fff;
            cursor: pointer;
            background-image:url(https://dev.krono-shop.com/media/vector/69/62/c7/backgrnd-AFTER.svg) !important;
            
            
        }

        .alert {
            padding: 20px;
            background-color: green;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
            
        }

        .closebtn:hover {
            color: black;
        }

        #generate:disabled,
        #generate[disabled],
        #delete:disabled,
        #delete[disabled]{
            border: 1px solid #999999;
            background-color: black !important;
            opacity: 0.5;
            color: #666666;
            cursor:not-allowed !important ;
        }


    </style>
<body role="document">

<div class="container theme-showcase" role="main">
    {block name="content/main"}{/block}
</div>

<script type="text/javascript" src="{link file="backend/base/frame/postmessage-api.js"}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


{block name="content/layout/javascript"}

{/block}
{block name="content/javascript"}{/block}
</body>
</html>