<?php
// Direct uploads requires PHP 5.5 on App Engine.
if (strncmp("5.5", phpversion(), strlen("5.5")) != 0) {
  die("Direct uploads require the PHP 5.5 runtime. Your runtime: " . phpversion());
}
?>
<html>
<body>
<form id="database" method="POST" enctype="multipart/form-data">
  Send these files:<p/>
  <input name="file" type="file" /><p/>
  <input type="submit" value="Upload image" />
</form>
</body>
</html>
<script>
$("form#data").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "https://whatsdown-d627f.appspot.com/api/?uploadImage=1",
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
