<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>연산자1</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <style>
        .table { border-collapse:collapse; }  
        .table th, .table td { border:1px solid black; }

        .bold{font-weight:bold;}
        font.holy {color: #FF6C21;}
        font.blue {color: #0000FF;}
        font.black {color: #000000;}

    </style>
    <script>
            
    </script>
</head>
<body>
    <!--콤보상자로 년/월 선택하기-->
    <form method="POST" action="calendar.php">
        <select name="year">
            <option value="2018" <?php if($_POST['year'] == '2018') echo 'selected' ;?> > 2018</option>
            <option value="2019" <?php if($_POST['year'] == '2019') echo 'selected' ;?> > 2019</option>
            <option value="2020" <?php if($_POST['year'] == '2020') echo 'selected' ;?> > 2020</option>
            <option value="2021" <?php if($_POST['year'] == '2021') echo 'selected' ;?> > 2021</option>
            <option value="2022" <?php if($_POST['year'] == '2022') echo 'selected' ;?> > 2022</option>
        </select>
        년

        <select name="month">
            <option value="01" <?php if($_POST['month'] == '01') echo 'selected' ;?> >01</option>
            <option value="02" <?php if($_POST['month'] == '02') echo 'selected' ;?> >02</option>
            <option value="03" <?php if($_POST['month'] == '03') echo 'selected' ;?>>03</option>
            <option value="04" <?php if($_POST['month'] == '04') echo 'selected' ;?>>04</option>
            <option value="05" <?php if($_POST['month'] == '05') echo 'selected' ;?>>05</option>
            <option value="06" <?php if($_POST['month'] == '06') echo 'selected' ;?>>06</option>
            <option value="07" <?php if($_POST['month'] == '07') echo 'selected' ;?>>07</option>
            <option value="08" <?php if($_POST['month'] == '08') echo 'selected' ;?>>08</option>
            <option value="09" <?php if($_POST['month'] == '09') echo 'selected' ;?>>09</option>
            <option value="10" <?php if($_POST['month'] == '10') echo 'selected' ;?>>10</option>
            <option value="11" <?php if($_POST['month'] == '11') echo 'selected' ;?>>11</option>
            <option value="12" <?php if($_POST['month'] == '12') echo 'selected' ;?>>12</option>
        </select>
        월
        
        <input type="submit" value="이동">
    </form>


<?php
    //공휴일 지정
    $Holidays = Array();
    $Holidays[] = array(0 => '01-1');
    $Holidays[] = array(0 => '03-1');
    $Holidays[] = array(0 => '05-5');
    $Holidays[] = array(0 => '06-6');
    $Holidays[] = array(0 => '07-17');
    $Holidays[] = array(0 => '08-15');
    $Holidays[] = array(0 => '10-3');
    $Holidays[] = array(0 => '10-9');
    $Holidays[] = array(0 => '12-25');

    echo "<table class='table'>";
    echo "<tr align=center>";
	echo "<th width=100>일</th>";
	echo "<th width=100>월</th>";
	echo "<th width=100>화</th>";
	echo "<th width=100>수</th>";
	echo "<th width=100>목</th>";
	echo "<th width=100>금</th>";
	echo "<th width=100>토</th>";
	echo "</tr>";

    $thisyear = date('Y'); // 4자리 연도 
    $thismonth = date('n'); // 0을 포함하지 않는 월 
    $today = date('j'); // 0을 포함하지 않는 일 
    //------ $year, $month 값이 없으면 현재 날짜 
    $year = isset($_POST['year']) ? $_POST['year'] : $thisyear; 
    $month = isset($_POST['month']) ? $_POST['month'] : $thismonth; 
    $day = isset($_POST['day']) ? $_POST['day'] : $today;

    $total_day = date('t', mktime(0, 0, 0, $_POST['month'] ,1, $_POST['year']));     //달의 일수 구하기
    $start_week = date('w', mktime(0,0,0,$_POST['month'],1,$_POST['year']));  //시작하는 요일 구하기
    $total_week = ceil(($total_day + $start_week) / 7);     //총 몇주인지 구하기
    $end_week = date('w', mktime(0,0,0,$_POST['month'],$total_day,$_POST['year']));     //마지막 요일 구하기    

    $day=1;

    for($i=1; $i <= $total_week; $i++){     //세로줄 만들기
        echo "<tr>";
        for ($j = 0; $j < 7; $j++) {    //가로줄 만들기
            //첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음
            echo '<td height="50" valign="top">';
            if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $end_week))) {
                if ($j == 0) {
                    //$j가 0이면 일요일이므로 빨간색
                    $style = "holy";
                } else if ($j == 6) {
                    //$j가 0이면 토요일이므로 파란색
                    $style = "blue";
                } else {
                    //그외는 평일이므로 검정색
                    $style = "black";
                }

                //공휴일이므로 빨간색
                for ($k = 0; $k < count($Holidays); $k++) {
                    if ($Holidays[$k][0] == $month . "-" . $day) {
                        $style = "holy";
                        //break;
                    }
                }

                //오늘 날짜면 굵은 글씨
                if ($year == $thisyear && $month == $thismonth && $day == date("j")) {
                    //날짜 출력
                    echo "<font class='bold'>"; 
                    echo $day; 
                    echo '</font>';
                } else {
                    echo '<font class='.$style.'>';
                    echo $day;
                    echo '</font>';
                }

                $day++;     //날짜 증가
            }
            echo '</td>';
        }
        echo "</tr>";
    }
    echo "</table>";
?>
