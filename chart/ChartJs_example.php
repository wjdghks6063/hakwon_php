<?php
    $connection = mysqli_connect("localhost", "fstack", "1234", "fullstack");   //DB 접속 (컴퓨터 주소, DB 아이디, DB 패스워드, DB 스키마명)

    $query = "SELECT id, name, age FROM h_member";
    $result = mysqli_query($connection, $query);

    $count = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chart.js 기초 예제</title>
        <!-- Chart.js 튜토리얼은 이쪽으로 -> https://www.chartjs.org/docs/latest/   -->

        <!-- Chart.js를 사용하기 위해 필요한 JavaScript 소스 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

        <link rel="stylesheet" href="ChartEx.css">
    </head>
    <body>
        <div id="container">
            <div class="default-chart"> <!--기본 차트명-->
                <h1>가장 기본적인 차트</h1>
                <!-- canvas 태그로 차트 소환
                id에는 차트의 이름, width height는 차트의 크기 -->
                <canvas id="myChart" width="600" height="600"></canvas>
            </div>

            <div class="custom-chart"> <!--선택 차트명    긁어다 사용할 때 필요--> 
                <h1>데이터베이스에 값 넣고 쓰는법</h1>
                <canvas id="memberChart" height="150"></canvas>
            </div>
        </div>

        

        <script type="text/javascript">
            /* div.default-chart */

            const ctx = document.getElementById('myChart'); //const는 var 같은거라고 생각하면 된다.

            const myChart = new Chart(ctx, {
                /**
                 * type: 차트의 종류
                 * 'bar' = 막대
                 * 'line' = 선
                 * 'pie' = 원형 (파이)
                 * 'doughnut' = 원형 (도넛)
                 * 'radar' = 레이더
                 * 'polarArea' = 폴라
                 * 'bubble' = 버블
                 * 'scatter' = 점선
                 */
                type: 'bar',
                data: {
                    //labels: 차트에 표시할 라벨들(이름들) (배열)
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],

                    datasets: [{
                        //label: 라벨들의 설명 (어떤 것에 대한 비교인지)
                        label: '# of Votes',
                        //data: 라벨들의 수치 데이터(배열)
                        data: [12, 19, 3, 5, 2, 3],
                        
                        //backgroundColor: 그래프의 막대 안쪽 색상(모든 색상 코드 사용 가능. ex)#fff222, aliceblue, 등등) (배열)
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],

                        //borderColor: 그래프의 막대 border의 색상 (배열) // 테두리
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],

                        //border의 굵기
                        borderWidth: 1
                    }]
                },

                //차트의 옵션
                options: {
                    responsive: false, //responsive: 반응형
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            /* div.custom-chart */

            //배열 선언
            var labels = []; // 변수가 [] 배열이다.
            var data = []; 
            
            var autoBackColors = []; //막대그래프 배경색
            var autoBorColors = []; // 막대그래프 테두리 선


            <?php
                //php, DB에서 가져온 값의 크기만큼 반복
                for($i=0; $i<$count; $i++) {
                    $row = mysqli_fetch_array($result);
            ?>
                var r = Math.floor(Math.random() * 255);    //Red 0~255 반복문이 돌면서 랜덤으로 값을 채우겠다.
                var g = Math.floor(Math.random() * 255);    //Green 0~255
                var b = Math.floor(Math.random() * 255);    //Blue 0~255

                labels.push("<?=$row['name']?>");           //push로 labels 배열에 DB에서 가져온 값을 반복문으로 차곡차곡 넣어준다.
                data.push("<?=$row['age']?>");

                autoBackColors.push("rgba("+r+", "+g+", "+b+", 0.2)");   //반복문이 돌때마다 색을 자동으로 넣어준다.
                autoBorColors.push("rgba("+r+", "+g+", "+b+", 1)");
            <?php
                }
            ?>

            //이렇게 따로 분리도 가능
            var config = {
                type: 'bar', 
                data: {
                    labels: labels,     //labels 프로퍼티에 위에 선언한 labels 배열 대입
                    datasets: [{
                        label: '회원의 나이', //중앙 위쪽에 표시된다.
                        data: data,     // data 프로퍼티에 위에서 선언한 data 배열 대입
                        backgroundColor: autoBackColors,
                        borderColor: autoBorColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, 
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };
            var memberCtx = document.getElementById('memberChart');
            var memberChart = new Chart(memberCtx, config);
        </script>
    </body>
</html>