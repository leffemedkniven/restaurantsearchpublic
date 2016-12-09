
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
<form id="data" method="POST" enctype="multipart/form-data">
  Upload image:<p/>
  <input name="file" type="file" /><p/>
  <input type="submit" value="Upload image" />
</form>
</body>
</html>
<script>
$("#data").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "https://whatsdown-d627f.appspot.com/api/?uploadImage=15",
            type: "POST",
            data: formData,
            async: false,
            success: function (data) {
                alert(data)
            },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    })
</script>
