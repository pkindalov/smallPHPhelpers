<?php
//create insert query
$data = [
    'home_team' => 'Home Team',
    'away_team' => 'Away Team',
    'home_team_goals' => 2,
    'away_team_goals' => 2
];

echo 'Data: <br />';
echo "<pre>";
    print_r($data);
echo "</pre>";

$query = create_insert_query(['data' => $data, 'table' => 'games']);
$bindStr = prepareParams(array_values($data));

echo 'Created query from data: <br />' . $query . '<br />';
echo 'Bind params string : ' . $bindStr;

function create_insert_query($data)
{
    list('data' => $data, 'table' => $table) = $data;
    $query = 'INSERT INTO ' . $table . ' ( ';
    $columns = array_keys($data);
    $query .= implode(',', $columns) . ') ';
    $query .= 'VALUES( ';
    $query .= append_bind_columns(['columns' => $columns]);
    $query .= ');';
    return $query;
}

function append_bind_columns($data)
{
    list('columns' => $columns) = $data;
    $query = '';
    foreach ($columns as $key => $value) {
        $query .= ':' . $value;
        if ($key < count($columns) - 1) {
            $query .=  ', ';
        }
    }
    return $query;
}



function prepareParams($params)
{
    $bindStr = getBindStr($params);
    return $bindStr;
}

function getBindStr($params)
{
    if (count($params) < 1) {
        throw new Exception('Params cannot be a zero');
    }
    $bindStr = '';
    $replaceChar = 's';
    foreach ($params as $param) {
        $firstLetter = getFirstLetter($param);
        if (!validateLetter($firstLetter)) {
            $bindStr .= $replaceChar;
            continue;
        }
        $bindStr .= $firstLetter;
    }
    return $bindStr;
}

function getFirstLetter($word)
{
    return substr(gettype($word), 0, 1);
}

function validateLetter($letter)
{
    $validLetters = ['i', 'd', 's', 'b'];
    return in_array($letter, $validLetters) ? $letter : false;
}
