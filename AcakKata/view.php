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
                    <button id="btn-enter" class="btn-primary" type="button" onclick="checkInput()" >Enter</button>
                </form>

                <div id="failure-notif" class="box-center"></div>
                <div id="status"></div>
            </div>
        </div>
    </body>
    <script src="statics/js/ajax.js"></script>
    <script>

        let score, correctword, responsearray;
        window.onload = function() {
            let url = "https://prisilamichelle.github.io/kata.txt";
            score = 0;
            let ajax = requestGet(
                url,
                null,
                function(response) {
                    responsearray = response.split(",");
                    correctword = pickRandomWord(responsearray);
                    document.getElementById('shuffled-word').innerHTML = shuffleWord(correctword);
                }
            );
        };

        function pickRandomWord(array) {
            let index = Math.floor(Math.random() * array.length);
            return array[index];
        }
        
        /* Fisher-Yates shuffle */
        function shuffleWord(word) {
            let i = 0, j = 0, temp = null;
            let wordarray = word.split("");
            for(let i = wordarray.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1))
                temp = wordarray[i];
                wordarray[i] = wordarray[j];
                wordarray[j] = temp;
            }
            return wordarray.join("");
        }

        let hideFailureNotif = function() {
            document.getElementById('failure-notif').style.display = "none";
        };

        let failureNotifTimer = null;
        let showFailureNotif = function(message) {
            document.getElementById('failure-notif').innerHTML = message;
            document.getElementById('failure-notif').style.display = "block";
            clearTimeout(failureNotifTimer);
            failureNotifTimer = setTimeout(hideFailureNotif, 2000);
        };

        function showStatus(status,score,shuffledword){
            if (status === true) {
                document.getElementById('status').innerHTML = "<h2>BENAR! Poin Anda : " + score + "<h2>";
                document.getElementById('input-word').value = "";
                document.getElementById('shuffled-word').innerHTML = shuffledword;
            } else {
                document.getElementById('status').innerHTML = "<h2>SALAH! Silakan coba lagi.<h2>";
            }
        }

        function checkInput() {
            let input = document.getElementById('input-word').value;
            if (input.trim() === "") {
                showFailureNotif("Harap masukkan kata sebelum menekan tombol enter.");
            } else {
                if (input === correctword) {
                    score = score + 1;
                    correctword = pickRandomWord(responsearray);
                    showStatus(true,score,shuffleWord(correctword));
                } else {
                    showStatus(false,score,null);
                }
            }   
        }

        document.getElementById("input-form").onkeypress = function(e) {
            let key = e.charCode || e.keyCode || 0;     
            if (key == 13) {
                e.preventDefault();
                checkInput();
            }
        }

    </script>
</html>