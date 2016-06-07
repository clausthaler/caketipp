<?php
    $uri = 'http://api.football-data.org/v1/soccerseasons/424/fixtures';
    $reqPrefs['http']['method'] = 'GET';
    $reqPrefs['http']['header'] = 'X-Auth-Token: 30a27429b58b414e92738f16fbb3550e';
    $reqPrefs['http']['proxy'] = 'tcp://wwwproxy.bahn-net.db.de:8080';
    $reqPrefs['http']['request_fulluri'] = true;
    $stream_context = stream_context_create($reqPrefs);
    $response = file_get_contents($uri, false, $stream_context);
    $fixtures = json_decode($response);
    $sql = '';
//(<{id: }>,<{name: }>,<{kickoff: }>,<{due: }>,<{datetime: }>,<{group_id: }>,<{team1_id: }>,<{team2_id: }>,<{round_id: }>,0,0,0,"2016-05-26 17:52:19",""2016-05-26 17:52:19"");

//    (<{id: }>,<{name: }>,<{iconurl: }>,"2016-05-26 17:52:19","2016-05-26 17:52:19");
    foreach ($fixtures->fixtures as $fixture) {
    	$teile = explode("/", $fixture->_links->self->href);
    	$hometeamteile = explode("/", $fixture->_links->homeTeam->href);
    	$awayteamteile = explode("/", $fixture->_links->awayTeam->href);
    	$sql = $sql . $fixturesql = ',(' 
    		. array_pop($teile) . ',"' 
    		. $fixture->homeTeamName . " - " . $fixture->awayTeamName . '",' 
    		. 'UNIX_TIMESTAMP(STR_TO_DATE("' . $fixture->date . '", "%Y-%m-%dT%T")),' 
    		. 'UNIX_TIMESTAMP(STR_TO_DATE("' . $fixture->date . '", "%Y-%m-%dT%T")),' 
    		. 'STR_TO_DATE("' . $fixture->date . '", "%Y-%m-%dT%T"),'
    		. array_pop($hometeamteile) . ','  
    		. array_pop($awayteamteile) . ','  
    		. '1,NULL, NULL,0,0,0,"2016-05-26 17:52:19","2016-05-26 17:52:19")';
//    	print_r($team->name);
//    	print_r($team->crestUrl);
    }
    $sql = $sql . ';';
	print_r($sql);

?>
