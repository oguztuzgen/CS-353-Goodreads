<html>

<head>
    <style>
        .rating {
            float: left;
            width: 300px;
        }

        .rating span {
            float: right;
            position: relative;
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


<body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <div class="rating">
        <span><input type="radio" name="rating" id="str5" value="5"><label for="str5"></label></span>
        <span><input type="radio" name="rating" id="str4" value="4"><label for="str4"></label></span>
        <span><input type="radio" name="rating" id="str3" value="3"><label for="str3"></label></span>
        <span><input type="radio" name="rating" id="str2" value="2"><label for="str2"></label></span>
        <span><input type="radio" name="rating" id="str1" value="1"><label for="str1"></label></span>
    </div>

    <script>
        $(document).ready(function() {
            // Check Radio-box
            $(".rating input:radio").attr("checked", false);

            $('.rating input').click(function() {
                $(".rating span").removeClass('checked');
                $(this).parent().addClass('checked');
            });

            $('input:radio').change(
                function() {
                    var userRating = this.value;
                    alert(userRating);
                });
        });
    </script>
</body>

</html>