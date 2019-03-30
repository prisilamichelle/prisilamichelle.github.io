<!DOCTYPE html>
<html>
    <head>
        <title>Game Acak Kata</title>
        <link rel="stylesheet" type="text/css" href="statics/css/home.css">
    </head>
    <body>
        <div id="main">
            <div id="box-input" class="center small">
                <h1>Acak Kata</h1>
                <span>Tebak kata :</span>
                <span id="shuffled-word"><?php echo $shuffledword; ?></span>

                <form id="input-form" action="controller.php" method="POST" autocomplete="off">
                    <p>Jawab : </p>
                    <input id="input-word" type="text" name="input-word" placeholder="Masukkan jawaban...">
                    <button id="btn-enter" class="btn-primary" type="button" onclick="checkEmptyInput()" >Enter</button>
                </form>

                <div id="failure-notif" class="box-center"></div>
                <div id="status"></div>
            </div>
        </div>
    </body>
    <script>
        let hideFailureNotif = function() {
            document.getElementById('failure-notif').style.display = "none";
        }

        let failureNotifTimer = null;
        let showFailureNotif = function(message) {
            document.getElementById('failure-notif').innerHTML = message;
            document.getElementById('failure-notif').style.display = "block";
            clearTimeout(failureNotifTimer);
            failureNotifTimer = setTimeout(hideFailureNotif, 2000);
        }

        function checkEmptyInput() {
            let input = document.getElementById('input-word').value;
            if (input.trim() === "") {
                showFailureNotif("Harap masukkan kata sebelum menekan tombol enter.");
            } else {
                checkInput(input);
            }   
        }

        document.getElementById("input-form").onkeypress = function(e) {
            let key = e.charCode || e.keyCode || 0;     
            if (key == 13) {
                e.preventDefault();
                checkEmptyInput();
            }
        }

    </script>
    <script src="statics/js/ajax.js"></script>
    <script>
        function checkInput(input){
            let data = 'input='+input;
            let ajax = {};
            ajax = requestPost(
                'controller.php',
                data,
                function(result) {
                    showStatus(result.data.status,result.data.score,result.data.shuffledword);
                }
            );
        }

        function showStatus(status,score,shuffledword){
            if (status === true) {
                document.getElementById('status').innerHTML = "<h2>BENAR! Poin Anda : " + score + "<h2>";
                document.getElementById('input-word').value = "";
                document.getElementById('shuffled-word').innerHTML = shuffledword;
            } else {
                document.getElementById('status').innerHTML = "<h2>SALAH! Silakan coba lagi.<h2>";
            }
        }

    </script>
</html>