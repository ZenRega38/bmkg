<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #fff; /* Loading screen background */
            font-family: sans-serif;
            overflow: hidden;
        }
        .loading-container {
          text-align: center;
        }

        .loading-gif {
             width: 100px;
             height: 100px;
             margin-bottom: 20px;
             object-fit: contain;
         }


        .loading-progress {
            width: 200px;
            height: 10px;
            background-color: #ddd;
            margin: 20px auto;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background-color: #007bff;
            transition: width 0.5s ease;
             border-radius: 5px;
        }
    </style>
</head>
<body>
   <div class="loading-container">
        <img id="loading-gif" class="loading-gif" src="../gif/load_1.gif" alt="Loading...">
       <div class="loading-progress">
          <div class="progress-bar" id="progress-bar"></div>
       </div>
   </div>
  <script>
        document.addEventListener("DOMContentLoaded", () => {
          const progressBar = document.getElementById("progress-bar");
            const loadingGif = document.getElementById("loading-gif");
            const gifPaths = [
                "../gif/load_1.gif",
                "../gif/load_2.gif",
                "../gif/load_3.gif",
                "../gif/load_4.gif",
                "../gif/load_5.gif",
                "../gif/load_6.gif",
            ];
          let progress = 0;
            let gifIndex = 0;

            function changeGif() {
            loadingGif.src = gifPaths[gifIndex];
            gifIndex = (gifIndex + 1) % gifPaths.length;
            }

             changeGif(); // Set the initial GIF

            const gifInterval = setInterval(changeGif, 1000)

           const simulateProgress = () => {
            if(progress < 100) {
               progress += 2;
               progressBar.style.width = `${progress}%`;
                const delay = progress > 80 ? 20 : 40;
                setTimeout(simulateProgress, delay);
             }else {
                    clearInterval(gifInterval); // stop gif change
                    window.location.href = '../../cuaca.php';
                }
           };

           setTimeout(simulateProgress, 100);
        });
    </script>
</body>
</html>