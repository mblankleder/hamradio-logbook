<?php

if (basename($_SERVER['SCRIPT_NAME'])=="search.php") {
    $edit_line = "<th rowspan=\"2\">Edit</th>";
}else{
    $edit_line = "";
}
echo '
<tr class="header">
    <th rowspan="2">
        Date
    </th>
    <th  colspan="2">
        Time UTC
    </th>
    <th rowspan="2">
        Band
    </th>
    <th rowspan="2">
        Frequency<br />
        (Mhz)
    </th>
    <th rowspan="2">
        Mode
    </th>
    <th rowspan="2">
        Power<br />
        (dBW)
    </th>
    <th rowspan="2">
        Country/Territory
    </th>
    <th rowspan="2">
        Station<br />
        Called/Worked
    </th>
    <th rowspan="2">
        Operator
    </th>
    <th  colspan="2">
        Report
    </th>
    <th  colspan="3">
        QSL
    </th>
    <th rowspan="2">
        Remarks
    </th>';
    echo $edit_line;
    echo'
</tr>
<tr class="header">
    <th>
        Start
    </th>
    <th>
        Finish
    </th>
    <th>
        Sent
    </th>
    <th>
        Rec\'d
    </th>
    <th>
        Sent
    </th>
    <th>
        Rec\'d
    </th>
    <th>
        Info
    </th>
</tr>
';
?>
