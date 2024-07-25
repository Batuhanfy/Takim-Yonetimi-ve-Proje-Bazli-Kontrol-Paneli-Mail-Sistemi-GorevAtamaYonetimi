<?php

session_regenerate_id(true);
require 'database.php';

if ($_POST) {
    $metin = $_POST["metin"];
    echo "<div class='ortala' style='height: unset; color: red'><b>Quil Editor den gelen değer:</b></div>";
    echo "<div class='ortala' style='height: unset'>$metin</div>";
} ?>



    <!-- Include quill editor stylesheet -->
    






<div id="quilleditor" style="width:100%"></div>
    <input type="hidden" id="newNote" name="metin">
    <!-- <button type="submit" class="buton">GÖNDER</button> -->
    <button id="saveNoteButton" class="btn btn-success">Ekle</button>





<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<body>

<script>
    //https://quilljs.com/docs/modules/toolbar/
    //Toolbar ayarları için ilgili bağlantıyı ziyaret edip orada bulunan bilgilerden faydalanabilirsiniz.

    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
        [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
        [{'direction': 'rtl'}],                         // text direction

        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
        [{'header': [1, 2, 3, 4, 5, 6, false]}],

        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
        [{'font': []}],
        [{'align': []}],
        ['link', 'image', 'video'],
        ['clean']                                         // remove formatting button
    ];

    const quill = new Quill('#quilleditor', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    });

    quill.on('text-change', function (delta, oldDelta, source) {
        document.getElementById("newNote").value = quill.root.innerHTML;
    });


    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<?php if ($_POST) echo "<script>alert('$metin')</script>"; ?>
</body>
</html>