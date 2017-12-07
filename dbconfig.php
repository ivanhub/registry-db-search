<?php

function request()
{
    if ("POST" == $_SERVER["REQUEST_METHOD"]) {
        if (isset($_SERVER["HTTP_ORIGIN"])) {
            $address = "https://" . $_SERVER["SERVER_NAME"];
            if (strpos($address, $_SERVER["HTTP_ORIGIN"]) !== 0) {
                exit("CSRF protection in POST request: detected invalid Origin header: " . $_SERVER["HTTP_ORIGIN"]);
            }
        }
    }
    
    if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != 'samarapb.ru') {
        die('Не балуйся');
    } else {
        
        
        $mysqli_link = mysqli_connect("127.0.0.1", "root", "local", "log");
        
        
        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        
        if (!$mysqli_link->set_charset("utf8")) {
            printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli_link->error);
            exit();
        }
        
        
        if ((isset($_POST['name'])) AND (isset($_POST['number']))) {
            
            // define the list of fields
            $fields = array(
                'name',
                'number',
                'date',
                'area',
                'organizatoin'
            );
            
            $conditions = "LOWER(SUBSTRING_INDEX(name, ' ', 1))  = '" . mysqli_real_escape_string($mysqli_link, mb_strtolower($_POST['name'])) . "'";
            
            $conditions2 = " LOWER(REPLACE(REPLACE(REPLACE(number, '-',''), ' ',''), '/', '')) ='" . mysqli_real_escape_string($mysqli_link, mb_strtolower(preg_replace('/[\\\\\s-\/]+/', '', $_POST['number']))) . "'";
            
            $query = "SELECT name,number,date,area,organization FROM registry";
            
            // if there are conditions defined
            if (count($conditions) > 0) {
                // append the conditions
                $query .= " WHERE " . $conditions . " AND " . $conditions2 . ""; // you can change to 'OR', but I suggest to apply the filters cumulative
            }
            
            $result = mysqli_query($mysqli_link, $query);
            
            if (!$result or !mysqli_num_rows($result)) {
                echo "<div class='notfound_wrap'><p style='font-size:100%;'><center><b>По Вашему запросу ничего не найдено</b></center><p></div><br><br><br>";
                
                // Записываем логи
                $query2 = "INSERT INTO registry_log (name, number) VALUES ('$_POST[name]', '$_POST[number]');";
                
                mysqli_query($mysqli_link, $query2);
                
            }
            
            if (isset($_POST['name'])) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $name         = $row['name'];
                    $number       = $row['number'];
                    $date         = $row['date'];
                    $area         = $row['area'];
                    $organization = $row['organization'];
                    
                    // echo "<b>ФИО:</b> $name<br><b>Номер удостоверения:</b> $number<br><b>Дата выдачи:</b> $date<br><b>Область аттестации:</b> $area<br><b>Организация:</b> $organization <br><br>";
                    
                    
?>

<div id="table_wrap">
<p style="text-align:center;margin-bottom:15px;"><strong>По Вашему запросу найдено:</strong></p>
    <table style="text-align:center;margin-bottom:40px;">
      <thead>
        <tr>
          <th>ФИО</th>
          <th>Дата выдачи</th>
          <th>Номер сертификата</th>
          <th>Направление</th>
          <th>Организация</th>
        </tr>
      </thead>
      <tbody>

          <tr>
            <td>
              <?= $name; ?>
            </td>
            <td>
              <?= $date; ?>
            </td>
            <td>
              <?= $number; ?>
            </td>
            <td>
        <?= $area; ?>
            </td>
           <td>
              <?= $organization; ?>
            </td>
          </tr>
      </tbody>
    </table>
</div>




<?php
                    
                }
                mysqli_close($mysqli_link);
            }
        }
    }
    
}

?>