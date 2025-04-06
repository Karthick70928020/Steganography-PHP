<!DOCTYPE html>
<html>
<head>
    <title>Advanced Text Steganography</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff10;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px 40px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #fff;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: none;
            border-radius: 10px;
            outline: none;
            background: #fff;
            color: #333;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 10px;
            background-color: #00b4db;
            background-image: linear-gradient(to right, #00b4db, #0083b0);
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-image: linear-gradient(to right, #0083b0, #00b4db);
        }

        .result-box {
            background: #ffffff20;
            border: 1px solid #ffffff40;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            color: #fff;
        }

        textarea#encodedText {
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Advanced Text Steganography</h2>

        
        <form method="post">
            <input type="text" name="secret_message" placeholder="Enter secret message" required>
            <button type="submit" name="encode">Encode</button>
        </form>

      
        <form method="post">
            <textarea name="encoded_text" placeholder="Paste encoded text here..." required></textarea>
            <button type="submit" name="decode">Decode</button>
        </form>

        <?php
        function generateRandomWord($length) {
            $characters = 'abcdefghijklmnopqrstuvwxyz';
            $word = '';
            for ($i = 1; $i < $length; $i++) {
                $word .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $word;
        }

        function encodeMessage($message) {
            $signature = '[STEGO]';
            $encodedWords = [];
            $chars = str_split($signature . $message);
            foreach ($chars as $char) {
                $randomWord = generateRandomWord(rand(4, 7));
                $encodedWords[] = $char . $randomWord;
            }
            return implode(' ', $encodedWords);
        }

        function decodeMessage($encodedText) {
            $words = explode(' ', trim($encodedText));
            $decoded = '';
            foreach ($words as $word) {
                $decoded .= $word[0];
            }

            if (strpos($decoded, '[STEGO]') === 0) {
                return substr($decoded, 7);
            } else {
                return "Invalid or unsupported encoded message.";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['encode'])) {
                $secret = htmlspecialchars($_POST['secret_message']);
                $encoded = encodeMessage($secret);
                echo "<div class='result-box'><strong>Encoded Text:</strong><br><textarea id='encodedText'>$encoded</textarea><br>
                <button onclick='copyText()'>Copy to Clipboard</button></div>";
            }

            if (isset($_POST['decode'])) {
                $text = $_POST['encoded_text'];
                $decoded = decodeMessage($text);
                echo "<div class='result-box'><strong>Decoded Message:</strong><br><p>$decoded</p></div>";
            }
        }
        ?>

        <script>
            function copyText() {
                var text = document.getElementById("encodedText");
                text.select();
                document.execCommand("copy");
                alert("Encoded text copied to clipboard!");
            }
        </script>
    </div>
</body>
</html>
